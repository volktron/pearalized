<?php

/*	MySQL Statement
 *	@author Henrik Volckmer
 */
 
namespace pearalized\datasource\mysql;

use pearalized\datasource\StatementInterface;

class Statement implements StatementInterface
{
	private $statement;
	
	public function __construct($statement)
	{
		$this->statement = $statement;
	}
	
	public function execute($params)
	{
		return 0;
	}
}

?>