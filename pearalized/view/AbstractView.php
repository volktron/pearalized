<?php

/*	AbstractView
 *	@author Henrik Volckmer
 */
 
namespace pearalized\view;

class AbstractView
{
	protected $data;
	protected $templates;
	
	public function __construct()
	{
	
	}
	
	public function add_data($data)
	{
		$this->data = array_merge_recursive($this->data, $data);
	}
}