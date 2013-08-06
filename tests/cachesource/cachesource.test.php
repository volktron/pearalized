<?php
/*
 * cachesource.test.php
 * @author Henrik Volckmer
 */
 
/**
 * @backupGlobals disabled
 * @backupStaticAttributes disabled
 */

class CachesourceTest extends PHPUnit_Framework_TestCase
{
	// Memcache
	protected $memcache_configuration = array(
		'type' => 'memcache',
		'host' => 'localhost',
		'port' => 11211
	);

	protected function connect_memcache()
	{
		$this->mc = p('cachesource')->setup($this->memcache_configuration);		
	}
	
	public function test_connect()
	{
		$this->connect_memcache();
	}
}

?>