<?php

require_once("config.php");

class SQLTreeTest extends PHPUnit_Framework_TestCase
{
	public function test_tokens()
	{
		$tokens = p("lib > SQLTree")->sql("SELECT a FROM b")->tokens();		
		$this->assertTrue(is_array($tokens) && sizeof($tokens) == 4);
		
		$tokens = p("lib > SQLTree")->sql("SELECT a,b,c FROM d")->tokens();		
		$this->assertTrue(is_array($tokens) && sizeof($tokens) == 6);
	}
	
	public function test_select_value_callback()
	{
		$function = function($in)
		{
			return "f(".$in.")";
		};
	
		// The first assertion is to verify the simplest working implementation
		$tree = p("lib > SQLTree")->sql("SELECT");
		$tree->callbacks(["select_values" => $function]);
		
		$this->assertEquals(
			"SELECT f(a) FROM b",
			$tree->out()
		);
	}
}

?>