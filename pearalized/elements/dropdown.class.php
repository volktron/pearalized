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
	}
	
	public function data(&$data)
	{
		$this->data = $data;
	}
	
	public function setup($params)
	{
	
	}
	
	public function html()
	{
		$out = "<select>";
		
		foreach ($data as $name => $label)
		{
			$out .= "<option name='$name'>$label</option>";
		}
		
		$out .= "</select>";
	}
}

?>