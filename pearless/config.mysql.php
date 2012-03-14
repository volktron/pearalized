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
		$this->sql_link = mysql_connect($db_host,$db_user,$db_pass);
		if (!$this->sql_link)
		{
			error_log("Can't connect to the database: ".mysql_error());
		}

		if (!mysql_select_db($db_name))
		{
			echo "database unavailable";
		}

		$this->sql_result 	= 0;
		$this->sql_affected = 0;
	}
	
	public function sql_query($sql) 
	{
		$this->sql_result = mysql_query($sql);
		$this->sql_affected = mysql_affected_rows();
		
		if (!$this->sql_result)
		{
			error_log(mysql_error());
		}
		else
		{
			return $this->sql_result;
		}
	}

	public function sql_row($result = false)
	{
		if (!$result)
			return mysql_fetch_assoc($this->sql_result);
		return mysql_fetch_assoc($result);
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
		return mysql_last_insert_id();
	}

	function sql_sanitize(&$data)
	{
		if (!is_array($data))
		{
			$data = mysql_real_escape_string($data);
		}
		
		foreach ($data as $element)
		{
			$this->sql_sanitize($element);
		}
	}
}

?>