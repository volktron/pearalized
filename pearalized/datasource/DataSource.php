<?php

/*	DataSource parent class
 *	@author Henrik Volckmer
 */
 
namespace pearalized\datasource;
class DataSource
{
	protected $profiling = array();	// Query profiling information
	protected $num_executed;		// Number of queries performed
	
	public function profile()
	{
		return $this->profiling;
	}
}