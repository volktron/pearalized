<?php

namespace pearless\datasource;

class DataSourceFactory
{
	public function setup($params)
	{
		$classpath = "pearless\\datasource\\".$params['type']."\\";
		require_once(PEARLESS_PATH."\\pearless\\datasource\\DataSourceInterface.php");
		require_once(PEARLESS_PATH."\\pearless\\datasource\\ResultInterface.php");
		require_once(PEARLESS_PATH."\\".$classpath."DataSource.php");
		require_once(PEARLESS_PATH."\\".$classpath."Result.php");

		$classname = $classpath."DataSource";
		return new $classname($params);
	}
}

?>