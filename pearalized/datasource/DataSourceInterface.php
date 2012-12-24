<?php

/*	DataSource Interface
 *	@author Henrik Volckmer
 */

namespace pearalized\datasource;

interface DataSourceInterface
{
	// Prepare a statement
	public function prepare($statement);
	
	// Execute it
	public function execute($statement, $params = null);
	
	// Return the last insert id
	public function last_insert_id();
	
	/*	Return profiling information, including:
	 *	- number of queries
	 *	- duration of each query
	 */
	public function profile();
}

?>