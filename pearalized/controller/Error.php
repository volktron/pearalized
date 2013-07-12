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
		$this->renderer->add_template("error.php");
	}
	
	public function execute()
	{		
		$this->renderer->render();
	}
}