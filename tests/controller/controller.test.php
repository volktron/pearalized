<?php
/*
 * controller.test.php
 * @author Henrik Volckmer
 */
 
/**
 * @backupGlobals disabled
 * @backupStaticAttributes disabled
 */

class ControllerTest extends PHPUnit_Framework_TestCase
{
	protected function create_controller()
	{
		$params = array(
			"controller"	=> "Error",
			"output"		=> "json"
		);	
		$controller = p("controller")->setup($params);
		return $controller;
	}
	
	public function test_create_controller()
	{
		$controller = $this->create_controller();
		$this->assertInstanceOf('\pearalized\controller\AbstractController',$controller);
	}
	
	public function test_json_output()
	{
		$this->expectOutputString('[]');
		$controller = $this->create_controller();
		echo $controller->output();
	}
}

?>