<?php

namespace routing;

class SushiResolver extends AbstractResolver
{
	public function __construct($path)
	{
		$this->path = $path;
	}
	
	public function eats($type)
	{
		$this->mealplan[] = $type;
		return $this;
	}
	
	public function resolve()
	{
		$meal = split("/",$this->path);
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
		
		
	}
}