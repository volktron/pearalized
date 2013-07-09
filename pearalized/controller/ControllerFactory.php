<?php

namespace pearalized\controller;

class ControllerFactory
{
	public function setup($params)
	{
		$classname = "pearalized\\controller\\".ucwords(strtolower($params['controller']));
		
		if(class_exists($classname))
			$object = new $classname($params);
		else
			$object = new \controller\Error($params);
		return $object;
	}
}