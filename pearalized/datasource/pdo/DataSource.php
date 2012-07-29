<?php

/*	PDO DataSource
 *	@author Henrik Volckmer
 */

namespace pearalized\datasource\pdo;

use pearalized\datasource\DataSourceInterface;
use PDO;
use PDOException;

class DataSource implements DataSourceInterface
{ 
	private $pdo;
	
	public $num_executed;			// Number of queries performed
	public $profiling = array();	// Query profiling information
	
	public function __construct($params)
	{	
		// Connect to the database
		try
		{
			$this->pdo = new PDO(
				$params['driver'].':dbname='.$params['database'].';host='.$params['host'],
				$params['user'],
				$params['pass']
			);
		}
		catch (PDOException $e)
		{
			throw new \Exception("PEARALIZED: Can't connect to the database - ".$e->getMessage());
		}

		$this->sql_result 	= 0;
	}
	
	public function prepare($statement)
	{
		$pdo_statement = $this->pdo->prepare($statement);
		return new Statement($pdo_statement);
	}
	
	public function execute($statement, $params = null)
	{
		$time_start = microtime(true);
		$pdo_statement = $this->pdo->query($statement);
		$time_total = microtime(true) - $time_start;
		
		$this->profiling[] = array(
			'time' => $time_total, 
			'rows' => $pdo_statement->rowCount()
		);
				
		if (!$pdo_statement)
		{
			throw new Exception("PEARALIZED: ".$this->pdo->errorInfo());
		}
		
		$this->affected = $pdo_statement->rowCount();
		return new Result($pdo_statement);
	}

	public function last_insert_id() 
	{
		return $this->pdo->lastInsertId();
	}

	public function sanitize(&$data)
	{
		// No need for this in PDO
	}
}

?>