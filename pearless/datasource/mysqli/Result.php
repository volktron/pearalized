<?php

/*	MySQLi Result
 *	@author Henrik Volckmer
 */
 
namespace pearless\datasource\mysqli;

use pearless\datasource\ResultInterface;
class Result implements ResultInterface
{
	private $result;
	
	public function __construct(&$result)
	{
		$this->result = $result;
	}
	
	public function fetch_row()
	{
		return mysqli_fetch_assoc($this->result);
	}

	public function fetch_all()
	{
		$data = array();
		$n = 0;
		while ($row = $this->fetch_row($this->result))
			$data[$n++] = $row;
			
		return $data;
	}
}

?>