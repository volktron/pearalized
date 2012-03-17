<?php

/*	DataSource Interface
 *	@author Henrik Volckmer
 */

namespace pearless\datasource;

interface DataSourceInterface
{
	public function prepare($statement);
	
	public function execute($statement, $params = null);
}

?>