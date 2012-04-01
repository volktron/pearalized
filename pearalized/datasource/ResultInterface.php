<?php

namespace pearalized\datasource;

interface ResultInterface
{
	public function fetch_row();
	
	public function fetch_all();
}