<?php
/* 
 * Pearless Mail
 * @author Vasudev Gadge
 */
 
namespace pearalized\mail;
class Mail
{
	private $send_to;		// array of TO email addresses
	private $send_cc;		// array of CC email addresses
	private $send_bcc;		// array of BCC email addresses
	
	private $message;			// message of the email 
	private $fullBody;			// message with attachment of the email 
	private $attachments = ''; 	
	
	private $email_headers;	// array containing mail headers
	private $headers;		// final email headers
	
	private $boundary;

	public function Mail()
	{
		$this->boundary = md5(time());
	}
	
	/*
	* Validates email addresses
	* @param $addresses array or single email address
	*/
	private function validate_email($addresses)
	{
		// if array
		if (is_array($addresses))
		{
			foreach($addresses as $address)
			{
				if(!preg_match('/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/',$address) ) 
				{
					throw new Exception("PEARALIZED: invalid email address - ".$address);
				}
			}
			return true;
		}
		// single email address
		else
		{
			if(!preg_match('/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/',$addresses) ) 
			{
				throw new Exception("PEARALIZED: invalid email address - ".$addresses);
			}
			return true;
		}
	}
	
	/*
	* set the subject for the mail
	* @param $subject string
	*/
	public function set_subject($subject)
	{
		$this->email_headers['Subject'] = $subject;
	}
	
	/*
	* set sender of the email
	* @param $from email address
	*/
	public function set_from($from)
	{
		if($this->validate_email($from))
			$this->email_headers['From'] = $from;
	}
	
	/*
	* set To email addresses
	* @param $to array of email addresses or just one single email address
	*/
	public function set_to($to)
	{
		if($this->validate_email($to))
		{
			if(is_array($to))
				$this->send_to = $to;
			else
				$this->send_to[] = $to;		
		}
	}
	
	/*
	* set CC email addresses
	* @param $cc array of email addresses or just one single email address
	*/
	public function set_cc($cc)
	{
		if($this->validate_email($cc))
		{
			if(is_array($cc))
				$this->send_cc = $cc;
			else
				$this->send_cc[] = $cc;		
		}
	}
	
	/*
	* set bcc email addresses
	* @param $bcc array of email addresses or just one single email address
	*/
	public function set_bcc($bcc)
	{
		if($this->validate_email($bcc))
		{
			if(is_array($bcc))
				$this->send_bcc = $bcc;
			else
				$this->send_bcc[] = $bcc;		
		}
	}
	
	/*
	* Set message of the email
	* @param $message string or html content
	*
	*/
	public function set_message($message)
	{
		$this->message = $message;	
	}
	
	/*
	* Build attachments
	* @param fileInfo	array 
	*					filename: name of the file
	*					path: path of the file OR
	*					data: file data as string
	* NOTE: Either path or data is to be provided for attachments. If provided both, path will be used
	*/
	public function attach($fileInfo)
	{
		foreach($fileInfo as $file)
		{
			if(isset($file['path']))
			{
				$f = fopen($file['path'],"rb");
				$data = fread($f,filesize($file['path']));
				fclose($f);
			}
			else if(isset($file['data']))
			{
				$data = $file['data'];
			}
			else
			{
				echo "PEARALIZED ERROR: NO file or data provided for attachment ".$file['name']; die;
			}
			
			$data = chunk_split(base64_encode($data));
			$this->attachments .= "Content-Type: {\"application/octet-stream\"};\n" . " name=".$file['name']."\n" . 
								"Content-Disposition: attachment;\n" . " filename=".$file['name']."\n" . 
								"Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
			$this->attachments .= "--$boundary\n";
		}
							
	}
	
	/*
	* send mail
	*
	*/
	public function send()
	{
		$this->headers = '';	//
		$this->email_headers['CC'] = implode(",", $this->send_cc);
		$this->email_headers['BCC'] = implode(",", $this->send_bcc);
		
		$this->headers['Content-Type'] = "multipart/mixed;\n boundary=\"$this->boundary\"";
		
		if($this->attachments != '')
		{
			$this->fullBody = "This is a multi-part message in MIME format.\n--$boundary\n";
			$this->fullBody .= "Content-Type: text/plain; charset=\"iso-8859-1\"\n";
			$this->fullBody .= "Content-Transfer-Encoding: 7bit\n\n" . $this->message ."\n";
			$this->fullBody .= $this->attachments;
		}
		else
		{
			$this->fullBody = $this->message;
		}
		
		//prepare header
		foreach($this->email_headers as $k=>$v)
		{
			$this->headers .= "$k: $v\n";
		}
		
		$this->send_to = implode(",", $this->send_to);
		//send email
		$res = @mail($this->send_to, $this->email_headers['Subject'], $this->fullBody, $this->headers);		
	}
	
	
	
	
}
?>