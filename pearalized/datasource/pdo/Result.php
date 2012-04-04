<?php

/*	PDO Result
 *	@author Henrik Volckmer
 */
 
namespace pearalized\datasource\pdo;

use pearalized\datasource\ResultInterface;
class Result implements ResultInterface
{
	private $result;
	
	public function __construct(&$result)
	{
		$this->result = $result;
	}
	
	public function fetch_row()
	{
		return $this->result->fetch();
	}

	public function fetch_all()
	{
		return $this->result->fetchAll();
	}
}

?>