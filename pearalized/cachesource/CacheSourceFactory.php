<?php

namespace pearalized\cachesource;

class CacheSourceFactory
{
	public function setup($params)
	{
		$classpath = "pearalized\\cachesource\\".$params['type']."\\";
		$filepath = "pearalized/cachesource/".$params['type']."/";
		require_once(PEARALIZED_PATH."/pearalized/cachesource/CacheSourceInterface.php");
		require_once(PEARALIZED_PATH."/".$filepath."CacheSource.php");
		
		$classname = $classpath."CacheSource";
		return new $classname($params);
	}
}

?>