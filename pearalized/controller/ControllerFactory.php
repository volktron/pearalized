<?php

namespace controller;

class ControllerFactory
{
	public function produce($pagedata)
	{
		$classname = "\\controller\\".ucwords(strtolower($pagedata['controller']));
		
		if(class_exists($classname))
			$object = new $classname($pagedata);
		else
			$object = new \controller\Error($pagedata);
		return $object;
	}
}