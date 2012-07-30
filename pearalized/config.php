<?php

/*	Config.php
 *	Pearless Configuration File
 *	@author Henrik Volckmer
 */

namespace pearalized\datasource;

// doc_root is normally one level above htdocs.
$doc_root = $_SERVER["DOCUMENT_ROOT"];
$htdocs = $doc_root."/htdocs";
$css_path = $htdocs."/css";
$pearalized_path = $doc_root."/pearalized";

defined('PEARALIZED_PATH') or define('PEARALIZED_PATH', $pearalized_path);

require_once(PEARALIZED_PATH . "/pearalized/pearalized.php");

$db_configuration = array(
	'type' => 'mysql',
	'host' => 'freya',
	'user' => 'root',
	'pass' => 'root',
	'database' => 'test'
);

$db = p('datasource')->setup($db_configuration);

// Memcached (optional)
$memcache_host = "localhost";
$memcache_port = 11211;

?>