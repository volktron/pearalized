<?php

/*	Memcached CacheSource
 *	@author Henrik Volckmer
 */

namespace pearalized\cachesource\memcache;

use pearalized\cachesource\CacheSourceInterface;
class CacheSource implements CacheSourceInterface
{ 
	// The memcache object
	protected $memcache;
	
	public function __construct($params)
	{
		$this->memcache = new \Memcache();
		// Connect to the database
		$this->memcache->connect(
			$params['host'],
			$params['port']
		);
		if (!$this->memcache)
		{
			throw new Exception("PEARALIZED: Can't connect to memcache - ".$params['host']);
		}
	}
	
	public function get($key)
	{	
		return $this->memcache->get($key); 
	}
	
	public function set($key, $value, $compression = 0, $expiration = 0) 
	{
		$success = $this->memcache->set($key, $value, $compression, $expiration);
		if ($success)
			return $value;
		return false;
	}
}

?>