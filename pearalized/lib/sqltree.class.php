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
	protected $text;
	
	public $parent_node;
	public $children = [];
	
	public function __construct($type, $text, $parent_node = null)
	{
		$this->type			= $type;
		$this->text			= $text;
		$this->parent_node	= $parent_node;
	}
	
	// Make sure we clean up properly...
	public function __destruct()
	{
		foreach($this->children as $child)
		{
			unset($child);
		}
	}
	
	public function __toString()
	{
		$out = $this->text;
		
		foreach($this->children as $child)
		{
			$out .= ' '.$child;
		}
		
		return $out;
	}
}

class SQLTree
{
	protected $sql;
	protected $callbacks;
	protected $tokens;
	
	protected $root;

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

	protected $functions = [
		
	];
	
	public function __construct()
	{
		$this->root = new SQLNode('root','');
	}
	
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
		$tmp = s($this->sql)->split("/([\s,\'\"()]+)/", true);
		
		$this->tokens = [];
		$s_quoted = false;
		$d_quoted = false;
		$buffer = "";
		foreach($tmp as $tok)
		{
			if (strlen(trim($tok)) > 0 || $s_quoted || $d_quoted)
			{
				if (!$d_quoted)
					if (trim($tok) == "'")
					{
						$s_quoted = !$s_quoted;
						$tok = trim($tok);
					}
				
				if (!$s_quoted)
					if (trim($tok) == "\"")
					{
						$d_quoted = !$d_quoted;
						$tok = trim($tok);
					}
				
				if ($s_quoted || $d_quoted)
					$buffer .= $tok;
				else
				{
					$this->tokens[] = $buffer.$tok;
					$buffer = "";
				}
			}
		}
		
		return $this;
	}
	
	public function tokens()
	{
		if (!$this->tokens)
			$this->tokenize();
			
		return $this->tokens;
	}
	
	protected function to_tree()
	{
		$last_node = $this->root;
		
		for($i = 0; $i < sizeof($this->tokens); $i++)
		{
			if ( in_array(s($this->tokens[$i])->lower(), $this->blocks) )
				$last_node = $last_node->parent_node;
			
			$new_node = new SQLNode(
							"node",
							$this->tokens[$i],
							$last_node);
							
			$this->root->children[] = $new_node;
			
			if ( in_array(s($this->tokens[$i])->lower(), $this->blocks) )
				$last_node = $new_node;
		}
		
		return $this;
	}
	
	public function out()
	{
		return ''.$this->tokenize()->to_tree()->root;
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