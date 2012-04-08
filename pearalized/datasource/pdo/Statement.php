<?php

/*	PDO Statement
 *	@author Henrik Volckmer
 */
 
namespace pearalized\datasource\pdo;

use pearalized\datasource\StatementInterface;
use PDOStatement;
use PDO;
class Statement implements StatementInterface
{
	private $statement;
	
	public function __construct($statement)
	{
		$this->statement = $statement;
	}
	
	public function execute($params)
	{
		foreach($params as $k => $v)
			if (is_int($v))
				$this->statement->bindValue($k, $v, PDO::PARAM_INT);
			else
				$this->statement->bindValue($k, $v, PDO::PARAM_STR);
		
		$this->statement->execute();
		return new Result($this->statement);
	}
}

?>