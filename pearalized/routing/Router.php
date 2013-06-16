<?php

namespace routing;

class Router
{
	protected $routes
	
	public function __construct()
	{
	
	}
	
	public function add($route)
	{
		$this->routes[] = $route;
		return $this;
	}
	
	public function resolve($path)
	{
		//
		return $controller;
	}
}

?>