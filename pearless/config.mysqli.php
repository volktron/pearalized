<?php

/*	config.mysql.php
 *	@author Henrik Volckmer
 *
 *	standard sql functions using mysql
 */

class PLDB 
{ 
	private $sql_link;
	private $sql_result;
	
	public $sql_affected;
	
	public function PLDB($db_host,$db_user,$db_pass,$db_name)
	{	
		// Connect to the database
		$this->sql_link = mysqli_connect($db_host,$db_user,$db_pass);
		if (!$this->sql_link)
		{
			error_log("Can't connect to the database: ".mysqli_error());
		}

		if (!mysqli_select_db($this->sql_link,$db_name))
		{
			echo "database unavailable";
		}

		$this->sql_result 	= 0;
		$this->sql_affected = 0;
	}
	
	public function sql_query($sql) 
	{
		$this->sql_result = mysqli_query($this->sql_link, $sql);
		$this->sql_affected = mysqli_affected_rows($this->sql_link);
		
		if (!$this->sql_result)
		{
			error_log(mysqli_error($this->sql_link));
		}
		
		return $this->sql_result;
	}

	public function sql_row($result = false)
	{
		if (!$result)
			return mysqli_fetch_assoc($sql_result);
		return mysqli_fetch_assoc($result);
	}

	public function sql_all($result = false)
	{
		if	(!$result)
			$result = $this->sql_result;
			
		$data = array();
		$n = 0;
		while ($row = $this->sql_row($result))
			$data[$n++] = $row;
			
		return $data;
	}

	public function sql_last_id() 
	{
		return mysqli_last_insert_id($sql_link);
	}

	public function sql_sanitize(&$data)
	{
		if (!is_array($data))
		{
			$data = mysqli_real_escape_string($this->sql_link, $data);
		}
		
		foreach ($data as $element)
		{
			$this->sql_sanitize($element);
		}
	}

}
?>