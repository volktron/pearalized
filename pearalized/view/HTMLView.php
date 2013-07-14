<?php

/*	HTMLView.php
 *	@author Henrik Volckmer
 */
 
namespace pearalized\view;

class HTMLView extends AbstractView
{
	public function __construct()
	{
		$this->templates	= array();
		$this->data			= array(
				"js" => array(),
				"css" => array()
			);
	}
	
	public function add_template($path)
	{
		$this->templates[] = $path;
	}
	
	public function add_js($path)
	{
		$this->add_data(
			array( "js" => array($path) )
		);
	}
	
	public function add_css($path)
	{
		$this->add_data(
			array( "css" => array($path) )
		);
	}
	
	public function add_css_text($content)
	{
		$this->add_data(
			array( "css_text" => array($content))
		);
	}
	
	public function render()
	{
		extract($this->data);
		
		foreach($this->templates as $template)
		{
			require_once($this->template_path.'/'.$template);
		}
	}
}