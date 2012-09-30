<?php

namespace pearalized\datasource;

class DataSourceFactory
{
	public function setup($params)
	{
		$classpath = "pearalized\\datasource\\".$params['type']."\\";
		
		$classname = $classpath."DataSource";
		return new $classname($params);
	}
}

?>