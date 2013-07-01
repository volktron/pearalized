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
	public function test_create_routing_objects()
	{
		$resolver = new \pearalized\routing\SushiResolver();
		$this->assertInstanceOf('\pearalized\routing\SushiResolver',$resolver);
	
		$route = new \pearalized\routing\Route("", $resolver);
		$this->assertInstanceOf('\pearalized\routing\Route',$route);
	
		$router = new \pearalized\routing\Router();
		$this->assertInstanceOf('\pearalized\routing\Router',$router);
	}
	
	public function test_simple_routing()
	{
		$resolver = new \pearalized\routing\SushiResolver();
		$resolver->eats(pearalized\routing\ROUTE_CONTROLLER);
		$resolver->eats(pearalized\routing\ROUTE_OUTPUT_TYPE);
		$resolver->eats(pearalized\routing\ROUTE_PARAM);
		
		$route = new \pearalized\routing\Route(
			"/(\w+)\/(\w+)\/(\w+)/",
			$resolver);
		$router = new \pearalized\routing\Router();
		
		$result = $router->resolve('/aaa/bbb/ccc');
		$this->assertEquals(0, $result);
		
		$router->add($route);
		$result = $router->resolve('/aaa/bbb/ccc');
		
		$this->assertEquals(
			array(
				"controller"	=> "aaa",
				"ajax"			=> false,
				"params"		=> array("ccc")
			),
			$result);
	}
}

?>