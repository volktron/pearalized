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
	public function test_create_controller()
	{
		$params = array(
			"controller" => "Error"
		);
		
		$controller = p("controller")->setup($params);
	}
}

?>