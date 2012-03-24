<?php
/* 
 * Pearless Mail
 * @author Vasudev Gadge
 */
 
namespace pearless\mail;
class Mail
{
	private $send_to;		// array of TO email addresses
	private $send_cc;		// array of CC email addresses
	private $send_bcc;		// array of BCC email addresses
	
	private $message;			// body/message/content of the email 
	private $attachments; 	// array of paths of files as attachments
	
	private $email_headers;	// array containing mail headers
	private $headers;		// final email headers

	public function Mail()
	{
		
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
					echo "PEARLESS ERROR: invalid email address".$address;die;
				}
			}
			return true;
		}
		// single email address
		else
		{
			if(!preg_match('/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/',$addresses) ) 
			{
				echo "PEARLESS ERROR: invalid email address".$addresses;die;
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
	* send mail
	*
	*/
	public function send_email()
	{
		$this->headers = '';	//
		$this->email_headers['CC'] = implode(",", $this->send_cc);
		$this->email_headers['BCC'] = implode(",", $this->send_bcc);
		
		//prepare header
		foreach($this->email_headers as $k=>$v)
		{
			$this->headers .= "$k: $v\n";
		}
		
		$this->send_to = implode(",", $this->send_to);
		//send email
		$res = @mail($this->send_to, $this->email_headers['Subject'], $this->message, $this->headers);		
	}
	
}
?>