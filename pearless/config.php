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
require_once("pearless.php");

// Database configuration
$db_type = "";
$db_host = "";
$db_user = "";
$db_pass = "";
$db_name = "";

// Memcached (optional)
$memcache_host = "localhost";
$memcache_port = 11211;

// Include database functions
require_once($pearless."/pearless/datasource/DataSourceInterface.php");
require_once($pearless."/pearless/datasource/ResultInterface.php");
require_once($pearless."/pearless/datasource/DataSourceFactory.php");

$db = DataSourceFactory::make_datasource(
		$db_type,
		array(	"db_host" => $db_host,
				"db_user" => $db_user,
				"db_pass" => $db_pass,
				"db_name" => $db_name));
		
?>