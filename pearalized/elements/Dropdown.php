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
	protected $selected;
	protected $script;
	protected $blank_option = true;
	protected $callback;
	
	protected $datasource_fetchmode;
	protected $datasource_fetchparam;
	
	protected $css = array(	// kv array of css classes
		"select" 			=> "dd_select",
		"option" 			=> "option",
	);
	
	public function __construct($params = array())
	{
		return $this->setup($params);
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
		$this->db = $db;
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
	
	// Set the name
	public function name($name)
	{
		$this->name = $name;
	}
	
	// Set the selected option
	public function selected($selected)
	{
		$this->selected = $selected;
	}
	
	// Set the blank option
	public function blank_option($blank_option)
	{
		$this->blank_option = $blank_option;
	}
	
	// Set the script
	public function script($blank_option)
	{
		$this->script = $script;
	}
	
	// Executes the query
	protected function execute_statement()
	{
		$fetchmode = $this->db->fetchmode();
		$this->datasource_fetchmode		= $fetchmode['fetchmode'];
		$this->datasource_fetchparam	= $fetchmode['fetchparam'];
		
		$ds = $this->db;
		$this->db->fetchmode($ds::FETCH_ASSOC);
		
		$result_set = $this->db->execute($this->statement)->fetch_all();
		
		if (count($result_set))
		{
			$columns = count($result_set[0]);
		}
		else
		{
			$columns = 0;
		}
		
		if ($columns == 2)
		{
			reset($result_set[0]);
			$key = key($result_set[0]);
			next($result_set[0]);
			$value = key($result_set[0]);
			
			foreach($result_set as $record)
			{
				$this->data[$record[$key]] = $record[$value];
			}
		}
		else if ($columns > 2)
		{
			$callback = $this->callback;
			foreach($result_set as $record)
			{
				$processed = $callback($record);
				$this->data[$processed["key"]] = $processed["value"];
			}
		}
		else if ($columns == 1)
		{
			$key = key($result_set[0]);
			foreach($result_set as $record)
			{
				$this->data[$key] = $key;
			}
		}
		else
		{
			$this->data = array();
		}
		
		$this->db->fetchmode($this->datasource_fetchmode, $this->datasource_fetchparam);
	}
	
	protected function default_callback($record)
	{
		reset($record);
		$key = current($record);
		$value = "";
		while(next($record) !== FALSE)
			$value .= current($record).' ';
		
		$value = substr($value,0,strlen($value)-1);
		return array(	"key"	=> $key,
						"value"	=> $value);
	}
	
	// output json
	// I'm not sure why anyone would ever need this, but it's easy to implement
	public function json()
	{
		return json_encode($this->data);
	}
	
	// draw the dropdown
	public function html()
	{
		$out = "<select class='".$this->css['select']."' id='".$this->name."' name='".$this->name."' ".$this->script.">";
		
		if ($this->blank_option)
		{
			$out .= "<option class='".$this->css['option']."' ></option>";
		}
		
		foreach ($this->data as $option => $label)
		{
			if (isset($this->selected) && $this->selected == $option)
				$out .= "<option selected='selected' class='".$this->css['option']."' value='$option'>$label</option>";
			else
				$out .= "<option class='".$this->css['option']."' value='$option'>$label</option>";
		}
		
		$out .= "</select>";
		
		return $out;
	}
	
	/*
	* One call dropdown setup function
	* @params
	* 		$params - associative array $key => $value
	*			Keys					Values
	*			'data'					2D array of data for the grid
	*	OR		'statement'				Statement to be used to procure data	
	*			'datasource'			Datasource
	*
	*			'name'					(optional) name of the dropdown
	*			'blank_option'			(optional) true/false - add blank option to dropdown
	*			'selected'				(optional) selected value of the dropdown
	*			'script'				(optional) javascript
	*/	
	public function setup($params)
	{
		
		if (isset($params['callback']) )
			$this->callback = $params['callback'];
		else
			$this->callback = function($record) { return $this->default_callback($record); };

		if (isset($params['data']) )
		{
			$this->data($params['data']);
		}
		else if (	isset($params['statement']) &&
					isset($params['datasource']))
		{
			$this->statement($params['datasource'],
							 $params['statement'],
							(isset($params['statement_now']) ? $params['statement_now'] : true));
		}
		else
		{
			throw new \Exception('PEARALIZED: No data or statement provided');
		}
		
		if (isset($params['name']) )
			$this->name = $params['name'];
			
		if (isset($params['blank_option']) )
			$this->blank_option = $params['blank_option'];
			
		if (isset($params['selected']) )
			$this->selected = $params['selected'];
			
		if (isset($params['script']) )
			$this->javascript = $params['script'];
			
		if (isset($params['css']) )
			$this->css($params['css']);
			
		return $this;
	}
	
	public function __toString()
	{
		return $this->html();
	}
}

?>