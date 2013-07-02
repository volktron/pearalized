<?php

namespace pearalized\routing;

const ROUTE_PARAM		= 1;
const ROUTE_CONTROLLER	= 2;
const ROUTE_OUTPUT_TYPE	= 3;
const ROUTE_JSON		= 4;
const ROUTE_RSS			= 5;
const ROUTE_XML			= 6;

class AbstractResolver
{
	protected $mealplan;
		
	public function __construct()
	{
	
	}
}