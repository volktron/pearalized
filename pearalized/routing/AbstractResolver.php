<?php

namespace pearalized\routing;

const ROUTE_PARAM		= 1;
const ROUTE_CONTROLLER	= 2;
const ROUTE_OUTPUT_TYPE	= 3;
const ROUTE_AJAX		= 4;
const ROUTE_RSS			= 5;
const ROUTE_XML			= 6;

class Resolver
{
	protected $path;
	protected $mealplan;
		
	public function __construct($path)
	{
		$this->path = $path;
	}
}