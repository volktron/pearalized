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
		try
		{
			$this->pdo = new PDO(
				$params['driver'].':dbname='.$params['database'].';host='.$params['host'],
				$params['user'],
				$params['pass']
			);
			
			if ($params['driver'] === 'mysql')
			{
				$this->pdo->setAttribute(
					PDO::ATTR_EMULATE_PREPARES, 
					false || (isset($params['emulate_prepares']) && $params['emulate_prepares']));
			}
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
						
		if (!$pdo_statement)
		{
			throw new \Exception("PEARALIZED: ".print_r($this->pdo->errorInfo(),true));
		}
		
		$this->profiling[] = array(
			'time' => $time_total, 
			'rows' => $pdo_statement->rowCount()
		);
		
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