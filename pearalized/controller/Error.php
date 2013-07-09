<?php

namespace pearalized\controller;

class Error extends AbstractController
{
	public function __construct($query)
	{
		$this->query = $query;
	}
	
	public function init()
	{
		$this->set_templates("error.php");
	}
	
	public function execute()
	{		
		$this->renderer->render();
	}
}