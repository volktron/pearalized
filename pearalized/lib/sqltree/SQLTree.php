<?php

/* SQLTree Class
 * @author Henrik Volckmer
 *
 */

namespace pearalized\lib\sqltree;

class SQLTree
{
	protected $sql;
	protected $callbacks;
	protected $tokens;
	
	protected $root;

	protected $blocks = array(	
		"select",
		"from",
		"where",
		"group by",
		"having",
		"order by",
		"limit",
		"procedure",
		"into outfile"	
	);
	
	protected $attributes = array(
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
	);

	protected $functions = array();
	
	public function __construct()
	{
		$this->root = new SQLNode('root','');
		$this->root->parent_node = $this->root;
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
		
		$this->tokens = array();
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
							
			$last_node->children[] = $new_node;
			
			if ( in_array(s($this->tokens[$i])->lower(), $this->blocks) )
				$last_node = $new_node;
		}
		
		return $this;
	}
	
	public function apply_callbacks()
	{
		$this->apply_callbacks_recursive($this->root,"");
		return $this;
	}
	
	public function apply_callbacks_recursive($node, $block)
	{
		$current_block = $block;
		$text_l = s($node->text)->lower();
		if (in_array($text_l,$this->blocks))
			$current_block = $text_l;
		else if($current_block != $text_l)
		{
			if ($current_block == "select" && isset($this->callbacks['select_fields']))
			{
				$node->text = $this->callbacks['select_fields']($node->text);
			}
		}
		foreach($node->children as $child)
		{
			$this->apply_callbacks_recursive($child, $current_block);
		}
	}
	
	public function out()
	{
		return trim($this->
					tokenize()->
					to_tree()->
					apply_callbacks()->
					root);
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