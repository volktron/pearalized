<?php

/*	Config.php
 *	Pearless Configuration File
 *	@author Henrik Volckmer
 */

namespace pearless\datasource;

// This is the document root, normally one level above htdocs.
$doc_root = $_SERVER["DOCUMENT_ROOT"];

// htdocs directory
$htdocs = $doc_root."/htdocs";

// CSS path relative 
$css_path = $htdocs."/css";

// Pearless path
$pearless = $doc_root."/pearless";
require_once($pearless."/pearless/pearless.php");

// Database configuration
$db_params = array(
	'type' => 'mysqli',
	'host' => 'localhost',
	'user' => 'root',
	'pass' => 'root',
	'database' => 'test'
);

$db = p('datasource')->setup($db_params);

// Memcached (optional)
$memcache_host = "localhost";
$memcache_port = 11211;
		
?>