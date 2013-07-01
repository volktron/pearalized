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
			"controller"	=> "Error",
			"ajax"			=> false,
			"params"		=> array()
		);
		
		for($i = 0; $i < count($meal); $i++)
		{
			switch($this->mealplan[$i])
			{
				case ROUTE_PARAM:		$resolution["params"][]		= $meal[$i]; break;
				case ROUTE_AJAX:		$resolution["ajax"]			= true; break;
				case ROUTE_CONTROLLER:	$resolution["controller"]	= $meal[$i]; break;
			}
		}
		
		return $resolution;
	}
}