<?php
/*
 * string.test.php
 * @author Henrik Volckmer
 */
 
 /**
 * @backupGlobals disabled
 * @backupStaticAttributes disabled
 */

class StringTest extends PHPUnit_Framework_TestCase
{


	public function test_string_compare()
	{
		$this->assertTrue("hello" == s("hello"));
	}
	
	public function test_trim()
	{
		$this->assertTrue("hello" == s(" hello ")->trim());
	}
	
	public function test_ltrim()
	{
		$this->assertTrue("hello" == s(" hello")->ltrim());
	}
	
	public function test_rtrim()
	{
		$this->assertTrue("hello" == s("hello ")->rtrim());
	}
	
	public function test_substring()
	{
		$this->assertTrue("ello" == s("hello")->sub(1));
		$this->assertTrue("ello" == s("hello")->sub("e"));		
	}
	
	public function test_upper()
	{
		$this->assertTrue("HELLO" == s("hello")->upper());
	}
	
	public function test_lower()
	{
		$this->assertTrue("hello" == s("HELLO")->lower());
	}

	public function test_replace()
	{
		// Test string
		$this->assertTrue("hello" == s("h")->replace("h","hello"));
		
		// Test regex
		$this->assertFalse("hello" == s("h")->replace("/h/","hello"));
		$this->assertTrue("hello" == s("h")->replace("/h/","hello",true));
	}
	
	
}

?>