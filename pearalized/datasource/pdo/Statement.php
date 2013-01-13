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
	protected $current_fetchmode;
	protected $current_fetchparam;
	
	public function __construct($statement, $fetchmode, $fetchparam)
	{
		$this->statement = $statement;
		$this->fetchmode = $fetchmode;
		$this->fetchparam = $fetchparam;
	}
	
	public function execute($params)
	{
		foreach($params as $k => $v)
			if (is_int($v))
				$this->statement->bindValue($k, $v, PDO::PARAM_INT);
			else
				$this->statement->bindValue($k, $v, PDO::PARAM_STR);
		
		$this->statement->execute();
		return new Result($this->statement, $this->current_fetchmode, $this->current_fetchparam);
	}
}

?>