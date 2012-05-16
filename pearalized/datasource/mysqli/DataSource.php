<?php

/*	MySQLi DataSource
 *	@author Henrik Volckmer
 */

namespace pearalized\datasource\mysqli;

use pearalized\datasource\DataSourceInterface;
class DataSource implements DataSourceInterface
{ 
	private $sql_link;
	
	public $affected;
	
	public function __construct($params)
	{	
		// Connect to the database					
		$this->sql_link = mysqli_connect(
			$params['host'],
			$params['user'],
			$params['pass']
		);
		if (!$this->sql_link)
		{
			throw new Exception("PEARALIZED: Can't connect to the database - ".mysql_error());
		}

		if (!mysqli_select_db($this->sql_link,$params['database']))
		{
			throw new Exception("PEARALIZED: Database unavailable");
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
			throw new Exception("PEARALIZED: ".mysqli_error($this->sql_link));
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