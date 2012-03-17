<?php

/*	MySQLi DataSource
 *	@author Henrik Volckmer
 */

namespace pearless\datasource\mysqli;

use pearless\datasource\DataSourceInterface;
class DataSource implements DataSourceInterface
{ 
	private $sql_link;
	
	public $sql_affected;
	
	public function __construct($params)
	{	
		// Connect to the database					
		$this->sql_link = mysqli_connect(
			$params['db_host'],
			$params['db_user'],
			$params['db_pass']
		);
		if (!$this->sql_link)
		{
			error_log("Can't connect to the database: ".mysqli_error());
		}

		if (!mysqli_select_db($this->sql_link,$params['db_name']))
		{
			echo "database unavailable";
		}

		$this->sql_result 	= 0;
		$this->sql_affected = 0;
	}
	
	public function prepare($statement){}
	
	public function execute($statement, $params = null)
	{
		$sql_result = mysqli_query($this->sql_link, $statement);
		$this->sql_affected = mysqli_affected_rows($this->sql_link);
		
		if (!$sql_result)
		{
			error_log(mysqli_error($this->sql_link));
		}
		
		return new Result($sql_result);
	}

	public function last_insert_id() 
	{
		return mysqli_last_insert_id($sql_link);
	}

	public function sanitize(&$data)
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