<?php

/*	CacheSource Interface
 *	@author Henrik Volckmer
 */

namespace pearalized\cachesource;

interface CacheSourceInterface
{
	public function get($key);
	
	public function set($key, $value, $compression = 0, $expiration = 0);
}

?>