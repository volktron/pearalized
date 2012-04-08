<?php

/*	MySQLi Statement
 *	@author Henrik Volckmer
 */
 
namespace pearalized\datasource\mysqli;

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