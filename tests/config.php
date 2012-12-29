<?php

/*	Config.php
 *	Pearless Configuration File
 *	@author Henrik Volckmer
 */

// doc_root is normally one level above htdocs.
$doc_root = ".";
$htdocs = $doc_root."/htdocs";
$css_path = $htdocs."/css";
$pearalized_path = $doc_root."";

defined('PEARALIZED_PATH') or define('PEARALIZED_PATH', $pearalized_path);

require_once(PEARALIZED_PATH . "/pearalized/pearalized.php");

// Memcached (optional)
$memcache_host = "localhost";
$memcache_port = 11211;

?>