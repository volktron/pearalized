<?php

/*	Config.php
 *	Pearless Configuration File
 *	@author Henrik Volckmer
 */

namespace pearless\datasource;

// doc_root is normally one level above htdocs.
$doc_root = $_SERVER["DOCUMENT_ROOT"];
$htdocs = $doc_root."/htdocs";
$css_path = $htdocs."/css";
$pearless_path = $doc_root."/pearless";

defined('PEARLESS_PATH') or define('PEARLESS_PATH', $pearless_path);

require_once(PEARLESS_PATH . "/pearless/pearless.php");

$db_configuration = array(
	'type' => 'mysqli',
	'host' => 'localhost',
	'user' => 'root',
	'pass' => 'root',
	'database' => 'test'
);

$db = p('datasource')->setup($db_configuration);

// Memcached (optional)
$memcache_host = "localhost";
$memcache_port = 11211;

?>