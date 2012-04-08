<?php

/*	PDO Result
 *	@author Henrik Volckmer
 */
 
namespace pearalized\datasource\pdo;

use pearalized\datasource\ResultInterface;
use PDO;
class Result implements ResultInterface
{
	private $result;
	
	public function __construct($result)
	{
		$this->result = $result;
	}
	
	public function fetch_row()
	{
		return $this->result->fetch(PDO::FETCH_ASSOC);
	}

	public function fetch_all()
	{
		return $this->result->fetchAll(PDO::FETCH_ASSOC);
	}
}

?>