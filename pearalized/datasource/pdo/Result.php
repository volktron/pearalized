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
	private $fetchmode;
	private $fetchparam;
	
	public function __construct($result, $fetchmode, $fetchparam)
	{
		$this->result = $result;
		$this->fetchmode = $fetchmode;
		$this->fetchparam = $fetchparam;
	}
	
	public function fetch_row()
	{
		return $this->result->fetch($this->fetchmode);
	}

	public function fetch_all()
	{
		return $this->result->fetchAll($this->fetchmode);
	}
}

?>