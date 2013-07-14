<?php

namespace pearalized\controller;

class Error extends AbstractController
{
	public function __construct($params)
	{
		parent::__construct($params);
	}
	
	public function init()
	{
		$this->renderer->add_template("error.php");
	}
}