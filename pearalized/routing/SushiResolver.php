<?php

namespace pearalized\routing;

class SushiResolver extends AbstractResolver
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function eats($type)
	{
		$this->mealplan[] = $type;
		return $this;
	}
	
	public function resolve($path)
	{
		$meal = array_values(array_filter(explode("/",$path),'trim'));
		
		$resolution = array(
			"params"	=> array()
		);
		
		for($i = 0; $i < count($meal); $i++)
		{
			switch($this->mealplan[$i])
			{
				case Route::ROUTE_PARAM:		$resolution["params"][]		= $meal[$i]; break;
				case Route::ROUTE_OUTPUT_TYPE:	$resolution["output"]		= $meal[$i]; break;
				case Route::ROUTE_CONTROLLER:	$resolution["controller"]	= $meal[$i]; break;
			}
		}
		
		return $resolution;
	}
}