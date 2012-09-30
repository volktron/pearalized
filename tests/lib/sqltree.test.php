<?php
/*
 * sqltree.test.php
 * @author Henrik Volckmer
 */
 
/**
 * @backupGlobals disabled
 * @backupStaticAttributes disabled
 */
require_once("config.php");

class SQLTreeTest extends PHPUnit_Framework_TestCase
{
	public function test_tokens()
	{
		$tokens = p("lib > sqltree > SQLTree")->sql("SELECT a FROM b")->tokens();		
		$this->assertTrue(is_array($tokens) && sizeof($tokens) == 4);
		
		$tokens = p("lib > sqltree > SQLTree")->sql("SELECT a,b,c FROM d")->tokens();		
		$this->assertTrue(is_array($tokens) && sizeof($tokens) == 8);
		
		$tokens = p("lib > sqltree > SQLTree")->sql("SELECT 'a b' as c FROM d")->tokens();		
		$this->assertTrue(is_array($tokens) && sizeof($tokens) == 6);

		$tokens = p("lib > sqltree > SQLTree")->sql("SELECT \"a ' b\" as c FROM d")->tokens();		
		$this->assertTrue(is_array($tokens) && sizeof($tokens) == 6);

		$tokens = p("lib > sqltree > SQLTree")->sql("SELECT (a b) as c FROM d")->tokens();		
		$this->assertTrue(is_array($tokens) && sizeof($tokens) == 9);
	}
	
	public function test_select_value_callback()
	{
		$function = function($in)
		{
			return "f(".$in.")";
		};
	
		// The first assertion is to verify the simplest working implementation
		$tree = p("lib > sqltree > SQLTree")->sql("SELECT a FROM b");
		$tree->callbacks(["select_values" => $function]);
		
		//print_r($tree->tokens());
		$this->assertEquals(
			"SELECT f(a) FROM b",
			$tree->out()
		);
	}
}

?>