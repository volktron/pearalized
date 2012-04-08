<?php

/*
 * sqltree.class.php
 * @author Henrik Volckmer
 *
 */

namespace pearalized\lib;

class SQLNode
{
	protected $type;
	protected $label;
	
	protected $children;
	
	// Make sure we clean up properly...
	public function __destruct()
	{
		foreach($children as $child)
		{
			unset($child);
		}
	}
}

class SQLTree
{
	protected $sql;
	protected $callbacks;
	protected $tokens;

	protected $blocks = [	
		"select",
		"from",
		"where",
		"group by",
		"having",
		"order by",
		"limit",
		"procedure",
		"into outfile"	
	];
	
	protected $attributes = [
		"all",
		"distinct",
		"distrinctrow",
		"high_priority",
		"straight_join",
		"sql_small_result",
		"sql_big_result",
		"sql_buffer_result",
		"sql_cache",
		"sql_no_cache",
		"sql_calc_found_rows",
		"asc",
		"desc",
		"with rollup",
		"offset",
		"character set"
	];

	public function sql($sql)
	{
		$this->sql = $sql;
		return $this;
	}
	
	public function callbacks($callbacks)
	{
		$this->callbacks = $callbacks;
		return $this;
	}
	
	protected function tokenize()
	{
		$this->tokens = s($this->sql)->split("/[\s,]+/");
	}
	
	public function tokens()
	{
		if (!$this->tokens)
			$this->tokenize();
			
		return $this->tokens;
	}
	
	protected function to_tree()
	{
		
	}
	
	public function out()
	{
		return '';
	}
	
	public function setup($params)
	{
		if(isset($params['sql']))
			$this->sql($params['sql']);
		else
		{
			// throw exception
		}
		
		if(isset($params['callbacks']))
			$this->callbacks($params['callbacks']);
			
		return $this;
	}
}

?>