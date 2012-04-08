<?php

namespace pearalized\datasource;

class DataSourceFactory
{
	public function setup($params)
	{
		$classpath = "pearalized\\datasource\\".$params['type']."\\";
		$filepath = "pearalized/datasource/".$params['type']."/";
		require_once(PEARALIZED_PATH."/pearalized/datasource/DataSourceInterface.php");
		require_once(PEARALIZED_PATH."/pearalized/datasource/ResultInterface.php");
		require_once(PEARALIZED_PATH."/pearalized/datasource/StatementInterface.php");
		require_once(PEARALIZED_PATH."/".$filepath."DataSource.php");
		require_once(PEARALIZED_PATH."/".$filepath."Result.php");
		require_once(PEARALIZED_PATH."/".$filepath."Statement.php");

		$classname = $classpath."DataSource";
		return new $classname($params);
	}
}

?>