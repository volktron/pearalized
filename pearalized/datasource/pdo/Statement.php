<?php

/*	PDO Statement
 *	@author Henrik Volckmer
 */
 
namespace pearalized\datasource\pdo;

use pearalized\datasource\StatementInterface;
use PDOStatement;
class Statement implements StatementInterface
{
	private $statement;
	
	public function __construct($statement)
	{
		$this->statement = $statement;
	}
	
	public function execute($params)
	{
		$this->statement->execute($params);
		return new Result($this->statement);
	}
}

?>