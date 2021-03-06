<?php

/**	AbstractController.php
 *	@author Henrik Volckmer
 */
 
namespace pearalized\controller;

abstract class AbstractController implements ControllerInterface
{
	protected $params;
	protected $output_data;
	
	public function __construct($params)
	{
		$this->params = $params;
		$this->output_data = array();
	}
	
	// TODO: use some sort of json rendering object
	public function json($flags = 0)
	{
		echo json_encode($this->output_data,$flags);
	}
	
	public function output()
	{
		$output_function = $this->params['output'];
		$this->$output_function();
	}
}