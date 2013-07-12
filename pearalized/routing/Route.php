<?php

namespace pearalized\routing;

class Route
{
	const ROUTE_PARAM		= 1;
	const ROUTE_CONTROLLER	= 2;
	const ROUTE_OUTPUT_TYPE	= 3;
	const ROUTE_JSON		= 4;
	const ROUTE_RSS			= 5;
	const ROUTE_XML			= 6;
	const ROUTE_HTML		= 7;
	
	protected $pattern;
	protected $resolver;
	
	public function __construct(
		$pattern,
		$resolver)
	{
		$this->pattern	= $pattern;
		$this->resolver	= $resolver;
	}
	
	public function matches($path)
	{
		return preg_match($this->pattern, $path);
	}
	
	public function resolve($path)
	{
		return $this->resolver->resolve($path);
	}
}