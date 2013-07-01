<?php

namespace pearalized\routing;

class RouterFactory
{
	public static function produce($params)
	{
		$classname = $params['resolver'];
		
		if(class_exists($classname))
			$object = new $classname($pagedata);
		else
			$object = new \routing\NullRouter($params);
		return $object;
	}
}