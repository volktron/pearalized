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
	
	public $affected;
	
	public function __construct($params)
	{	
		// Connect to the database
		try
		{
			$this->pdo = new PDO(
				$params['host'],
				$params['user'],
				$params['pass']
			);
		}
		catch (PDOException $e)
		{
			throw new Exception("PEARALIZED: Can't connect to the database - ".$e->getMessage());
		}

		$this->sql_result 	= 0;
		$this->sql_affected = 0;
	}
	
	public function prepare($statement)
	{
		$pdo_statement = $this->pdo->prepare($statement);
		return new Statement($pdo_statement);
	}
	
	public function execute($statement, $params = null)
	{
		$pdo_statement = $this->pdo->query($statement);
		
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