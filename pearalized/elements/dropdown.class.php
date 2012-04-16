<?php

/*
 * dropdown.class.php
 * @author Henrik Volckmer
 *
 */

namespace pearalized\elements;

class Dropdown
{
	protected $name;
	protected $data;

	protected $css = array(	// kv array of css classes
		"select" 			=> "dd_select",
		"option" 			=> "option",
	);
	
	public function __construct(&$data = null, $name = null)
	{
		$this->data = $data;
		
		return $this;
	}
	
	public function data(&$data)
	{
		$this->data = $data;
		
		return $this;
	}
	
	public function html()
	{
		$out = "<select id='".$this->name."'>";
		
		foreach ($this->data as $name => $label)
		{
			$out .= "<option name='$name'>$label</option>";
		}
		
		$out .= "</select>";
		
		return $out;
	}
	
	/*
	* One call dropdown setup function
	* @params
	* 		$params - associative array $key => $value
	*				Keys					Values
	*				'data'					2D array of data for the grid
	*				'name'					name of the dropdown
	*/	
	public function setup($params)
	{
		if (isset($params['data']) )
			$this->data = $params['data'];
			
		if (isset($params['name']) )
			$this->name = $params['name'];
			
		return $this;
	}
}

?>