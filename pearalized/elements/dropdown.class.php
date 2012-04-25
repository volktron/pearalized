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
	
	// Set the data
	public function data(&$data)
	{
		$this->data = $data;
		
		return $this;
	}
	
	// Set the statement
	public function statement($db, $statement, $now=true)
	{
		$this->statement = $statement;
		
		if($now)
			$this->execute_statement();
		
		return $this;
	}
	
	// Set the CSS
	public function css($css)
	{
		$this->css = $css;
		
		return $this;
	}
	
	// Executes the query
	protected function execute_statement()
	{
		$this->data = $this->db->execute($this->statement)->fetch_all();

		if ($this->using_statement_headers)
				$this->bind_headers_top( array_keys($this->data[0]) );
	}
	
	// draw the dropdown
	public function html()
	{
		$out = "<select class='".$this->css['select']."' id='".$this->name."'>";
		
		foreach ($this->data as $name => $label)
		{
			$out .= "<option class='".$this->css['option']."' name='$name'>$label</option>";
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
			$this->data($params['data']);
		else if (isset($params['statement']))
			$this->statement($params['statement']);
		else
			echo 'PEARALIZED ERROR: No data or statement provided'; die;
			
		if (isset($params['name']) )
			$this->name = $params['name'];
			
		if (isset($params['css']) )
			$this->css($params['css']);
			
		return $this;
	}
}

?>