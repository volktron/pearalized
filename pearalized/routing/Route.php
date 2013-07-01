<?php

namespace pearalized\routing;

class Route
{
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