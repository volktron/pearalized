<?php

namespace pearalized\datasource;

class DataSourceFactory
{
	public function setup($params)
	{
		$classpath = "pearalized\\datasource\\".$params['type']."\\";
		require_once(PEARALIZED_PATH."\\pearalized\\datasource\\DataSourceInterface.php");
		require_once(PEARALIZED_PATH."\\pearalized\\datasource\\ResultInterface.php");
		require_once(PEARALIZED_PATH."\\".$classpath."DataSource.php");
		require_once(PEARALIZED_PATH."\\".$classpath."Result.php");

		$classname = $classpath."DataSource";
		return new $classname($params);
	}
}

?>