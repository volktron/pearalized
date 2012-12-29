<?php

/* SQLNode Class
 * @author Henrik Volckmer
 *
 */
 
namespace pearalized\lib\sqltree;

class SQLNode
{
	public $type;
	public $text;
	
	public $parent_node;
	public $children = array();
	
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

?>