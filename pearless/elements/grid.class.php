<?php

/*
 * grid.class.php
 * @author Henrik Volckmer
 *
 */
 
class Grid 
{
	private $data;			// 2d array of data
	private $headers_top;	// 1d array of header strings
	private $headers_left;	// 1d array of header strings
	
	private $callbacks;
	private $args;
	
	private $using_sql;
	private $using_sql_headers;
	
	private $db;
	
	private $css = array(	// kv array of css classes
		"table" 			=> "grid_table",
		"row" 				=> "grid_row",
		"cell" 				=> "grid_cell",
		"header_row" 		=> "grid_header_row",
		"header_cell"		=> "grid_header_cell",
		"header_cell_left"	=> "grid_header_cell_left"
	);
	
	public function Grid(&$data=null, $headers_top=false, $array=true)
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
	
	// Create data from a SQL query
	public function bind_statement($db, $statement, $headers=true, $now=false)
	{
		$this->db			= $db;
		$this->statement		= $statement;
		$this->using_sql 		= true;
		$this->using_sql_headers 	= $headers;
		
		if ($now)
			$this->execute_sql();
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
	* Takes an associative array of $colname => $function
	*
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
			$n = 0;
			foreach($callbacks as $k => $v)
			{
				if (is_integer($k))
					$this->callbacks[$k] = $v;
			}
		}
		else
		{
			$this->callbacks = $callbacks;	
		}
		
		//considering extra arguments for callback functions
		$this->args = $args;
	}
	
	// Executes the query
	private function execute_sql()
	{
		$this->data 	= $this->db->execute($this->statement)->fetch_all();
		
		if ($this->using_sql_headers)
				$this->bind_headers_top( array_keys($this->data[0]) );
	}
	
	// draw the grid
	public function render_html()
	{	
		// If we want to get our data at render time
		if ($this->using_sql && !$this->data)
			$this->execute_sql();
		
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
				$out .= "<th class='".$this->css['header_cell']."'>". $header ."</th>";
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
			
			$c = 0;
			foreach($row as $cell)
			{	
				// data to be sent to callback function
				$data = array(
					'record'	=> $row,
					'index'		=> $c
				);
				
				//check if callbacks is array and callback function for current field index is set 
				if (is_array($this->callbacks) && isset($this->callbacks[$c]))
					$cell = $this->callbacks[$c]($data, $this->args);
				else
					$cell = $this->callbacks($data, $this->args);
						
				$out .= "<td class='". $this->css['cell'] ."'>". $cell ."</td>";
				$c++;
			}
			$out .= "</tr>";
		}
		$out .= "</table>";
		
		return $out;
	}
}

?>