<?php

/*	MySQL DataSource
 *	@author Henrik Volckmer
 */

namespace pearless\datasource\mysql;

use pearless\datasource\DataSourceInterface;
class DataSource implements DataSourceInterface
{ 
	private $sql_link;
	
	public $sql_affected;
	
	public function __construct($params)
	{
		// Connect to the database
		$this->sql_link = mysql_connect(
			$params['host'],
			$params['user'],
			$params['pass']
		);
		if (!$this->sql_link)
		{
			error_log("Can't connect to the database: ".mysql_error());
		}

		if (!mysql_select_db($params['database']))
		{
			echo "database unavailable";
		}

		$this->sql_result 	= 0;
		$this->sql_affected = 0;
	}
	
	public function prepare($statement){}
	
	public function execute($statement, $params = null)
	{
		$sql_result = mysql_query($statement);
		$this->sql_affected = mysql_affected_rows();
		
		if (!$sql_result)
		{
			error_log(mysql_error());
		}
		else
		{
			return new Result($sql_result);
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