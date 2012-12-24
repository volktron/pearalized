<?php

/*	MySQL DataSource
 *	@author Henrik Volckmer
 */

namespace pearalized\datasource\mysql;

use pearalized\datasource\DataSourceInterface;
class DataSource extends \pearalized\datasource\DataSource implements DataSourceInterface
{ 
	protected $sql_link;
	
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
			throw new Exception("PEARALIZED: Can't connect to the database - ".mysql_error());
		}

		if (!mysql_select_db($params['database']))
		{
			throw new Exception("PEARALIZED: Database unavailable");
		}

		$this->sql_result 	= 0;
		$this->sql_affected = 0;
	}
	
	public function prepare($statement){}
	
	public function execute($statement, $params = null)
	{
		$time_start = microtime(true);
		$sql_result = mysql_query($statement);
		$time_total = microtime(true) - $time_start;
		
		$this->profiling[] = array(
			'time' => $time_total, 
			'rows' => mysql_affected_rows($this->sql_link)
		);
		
		if (!$sql_result)
		{
			throw new Exception("PEARALIZED: ".mysql_error());
		}
		else
		{
			$this->num_executed++;
			return new Result($sql_result);
		}
	}

	public function fetch_row($result = false)
	{
		if (!$result)
			return mysql_fetch_assoc($this->sql_result);
		return mysql_fetch_assoc($result);
	}

	public function fetch_all($result = false)
	{
		if	(!$result)
			$result = $this->sql_result;
		
		$data = array();
		$n = 0;
		while ($row = $this->sql_row($result))
			$data[$n++] = $row;
			
		return $data;
	}

	public function last_insert_id() 
	{
		return mysql_insert_id();
	}

	public function sanitize(&$data)
	{
		if (!is_array($data))
		{
			$data = mysql_real_escape_string($data);
		}
		
		foreach ($data as $element)
		{
			$this->sanitize($element);
		}
		
		return $data;
	}
}

?>