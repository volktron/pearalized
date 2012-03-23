<?php

/*
 * grid.class.php
 * @author Henrik Volckmer
 *
 */

namespace pearless\elements;
class Grid
{
	private $data;			// 2d array of data
	private $headers_top;	// 1d array of header strings
	private $headers_left;	// 1d array of header strings

	private $callbacks;
	private $args;

	private $using_statement;
	private $using_statement_headers;

	private $db;

	private $css = array(	// kv array of css classes
		"table" 			=> "grid_table",
		"row" 				=> "grid_row",
		"cell" 				=> "grid_cell",
		"header_row" 		=> "grid_header_row",
		"header_cell"		=> "grid_header_cell",
		"header_cell_left"	=> "grid_header_cell_left"
	);

	public function __construct(&$data=null, $headers_top=false, $array=true)
	{
		if ($data != null)
			bind_data($data, $headers_top, $array);
	}

	// Takes data from some source
	public function bind_data(&$data, $headers_top=false, $array=true)
	{
		if ($array)
			$this->data = $data;

		if ($headers_top)
			$this->bind_headers_top( array_keys($this->data[0]) );
	}
	public function data(&$data, $headers_top=false, $array=true)
	{
		$this->bind_data($data, $headers_top, $array);
		return $this;
	}

	// Create data from a SQL query
	public function bind_statement($db, $statement, $headers=true, $now=true)
	{
		$this->db						= $db;
		$this->statement				= $statement;
		$this->using_statement 			= true;
		$this->using_statement_headers 	= $headers;

		if ($now)
			$this->execute_statement();
	}

	// Get header strings for top row headers
	public function bind_headers_top($headers)
	{
		$this->headers_top = $headers;
	}

	// Get header strings for left column headers
	public function bind_headers_left($headers)
	{
		$this->headers_left = $headers;
	}

	/* Assign Callback functions
	* @params
	*		$callbacks	associative array of $colname => $function OR just single callback function
	*		$args		extra arguments to be sent to callback function
	*/
	public function assign_callbacks($callbacks, $args=array())
	{
		if (is_array($callbacks))
		{
			// handle associative callback arrays
			$n = 0;
			$callback_columns = array_keys($callbacks);
			foreach($this->headers_top as $column)
			{
				if (in_array($column, $callback_columns))
					$this->callbacks[$n] = $callbacks[$column];

				$n++;
			}

			// handle non-associative callback arrays
			foreach($callbacks as $k => $v)
			{
				if (is_integer($k))
					$this->callbacks[$k] = $v;
			}
		}
		else
		{
			// Use headers array if available
			if(isset($this->headers_top))
			{
				$n = 0;
				foreach($this->headers_top as $column)
				{
					$this->callbacks[$n] = $callbacks;
					$n++;
				}
			}
			// Use first row of data as a fallback
			else
			{
				$num_cols = count($this->data[0]);
				for ($i = 0; $i < $num_cols; $i++)
					$this->callbacks[$i] = $callbacks;

				// set headers_top using keys of data array
				$this->headers_top = array_keys($this->data[0]);
			}
		}

		//considering extra arguments for callback functions
		$this->args = $args;
	}

	// Executes the query
	private function execute_statement()
	{
		$this->data = $this->db->execute($this->statement)->fetch_all();

		if ($this->using_statement_headers)
				$this->bind_headers_top( array_keys($this->data[0]) );
	}

	// draw the grid
	public function html()
	{
		// If we want to get our data at render time
		if ($this->using_statement && !$this->data)
			$this->execute_statement();

		// Table declaration
		$out = "<table class='".$this->css['table']."'>";

		// Top header row start
		if (is_array($this->headers_top))
		{
			$out .= "<tr class='".$this->css['header_row']."'>";
		}

		// Top-left corner div
		if (is_array($this->headers_top) && is_array($this->headers_left))
		{
			$out .= "<th class='".$this->css['header_cell']."'></th>";
		}

		// Top headers
		if (is_array($this->headers_top))
		{
			foreach($this->headers_top as $header)
			{
				$out .= "<th class='".$this->css['header_cell']."'>".$header."</th>";
			}

			$out .= "</tr>";
		}

		// Data
		$n = 0;
		foreach($this->data as $row)
		{
			$out .= "<tr class='".$this->css['row']."'>";

			// Left headers
			if (is_array($this->headers_left))
			{
				$out .= "<td class='".	$this->css['cell']." ".
										$this->css['header_cell_left']."'>".
							$this->headers_left[$n++].
						"</td>";
			}

			// data to be sent to callback function
			$data = array(
				'record' => $row
			);

			$c = 0;
			foreach($row as $cell)
			{
				$data['index'] = $this->headers_top[$c];

				// Is there a callback function for this column?
				if (isset($this->callbacks[$c]))
					$cell = $this->callbacks[$c]($data, $this->args);

				$out .= "<td class='". $this->css['cell'] ."'>".$cell."</td>";
				$c++;
			}
			$out .= "</tr>";
		}
		$out .= "</table>";

		return $out;
	}

	/*
	* One call grid setup function
	* @params
	* 		$classnames - associative array $key => $value
	*/
	public function css($classnames)
	{
		foreach($this->css as $key => $name)
		{
			if (isset($classnames[$key]))
				$this->css[$key] = $classnames[$key];
		}
		
		return $this;
	}
	
	/*
	* One call grid setup function
	* @params
	* 		$params - associative array $key => $value
	*				Keys					Values
	*				'data'					2D array of data for the grid
	*		OR		'statement'				Query to be used for data
	*				'datasource'			Datasource Object
	*				'statement_headers'		(Optional) default value true
	*				'statement_now'			(Optional) default value true
	*				'headers_top'			(Optional) Column headers for the grid
	*				'headers_row'			(Optional) Row headers for the grid
	*				'callbacks'				(Optional) Callback functions array or just single function name
	*
	*/
	public function setup($params)
	{
		if (isset($params['data']))
			$this->bind_data($params['data']);
		else if (	isset($params['statement']) &&
					isset($params['datasource']))
			$this->bind_statement(	$params['datasource'],
									$params['statement'],
									(isset($params['statement_headers']) ? $params['statement_headers'] : true),
									(isset($params['statement_now']) ? $params['statement_now'] : true));
		else
		{
			echo 'PEARLESS ERROR: No data or statement provided'; die;
		}

		if (isset($params['headers_top']))
			$this->bind_headers($params['headers_top']);
		if (isset($params['headers_left']))
			$this->bind_headers_left($params['headers_left']);
		if (isset($params['callbacks']))
			$this->assign_callbacks($params['callbacks']);

		return $this;
	}
}

?>