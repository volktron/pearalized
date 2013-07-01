<?php

namespace pearalized\routing;

class Router
{
	protected $routes;
	
	public function __construct()
	{
		$this->routes = array();
	}
	
	public function add($route)
	{
		$this->routes[] = $route;
		return $this;
	}
	
	public function resolve($path)
	{
		foreach($this->routes as $route)
		{
			if ($route->matches($path))
				return $route->resolve($path);
		}
		return 0;
	}
}

?>