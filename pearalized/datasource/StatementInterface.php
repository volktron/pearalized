<?php

/*	Statement Interface
 *	@author Henrik Volckmer
 */

namespace pearalized\datasource;

interface StatementInterface
{
	public function execute($params);
}

?>