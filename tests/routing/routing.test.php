<?php
/*
 * datasource.test.php
 * @author Henrik Volckmer
 */
 
/**
 * @backupGlobals disabled
 * @backupStaticAttributes disabled
 */

class RoutingTest extends PHPUnit_Framework_TestCase
{
	public function test_create_router()
	{
		$router = new \pearalized\routing\Router();
		$this->assertInstanceOf('\pearalized\routing\Router',$router);
	}
}

?>