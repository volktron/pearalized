<?php

/*	config.mysql.php
 *	@author Henrik Volckmer
 *
 *	standard sql functions using mysql
 */

// Connect to the database
$sql_link		= mysql_connect($db_host,$db_user,$db_pass);
if (!$sql_link)
{
	error_log("Can't connect to the database: ".mysql_error());
}

if (!mysql_select_db($db_name))
{
	echo "database unavailable";
}

$sql_result 	= 0;
$sql_affected 	= 0;

function sql_query($sql) 
{
	global $sql_result, $sql_affected;
	$sql_result = mysql_query($sql);
	$sql_affected = mysql_affected_rows();
	
	if (!$sql_result)
	{
		// error handling
		error_log(mysql_error());
	}
	else
	{
		return $sql_result;
	}
}

function sql_row($result = false)
{
	global $sql_result;
	if (!$result)
		return mysql_fetch_assoc($sql_result);
	return mysql_fetch_assoc($result);
}

function sql_all($result = false)
{
	global $sql_result;
	if	(!$result)
		$result = $sql_result;
	
	$n = 0;
	while ($row = sql_row($result))
		$data[$n++] = $row;
		
	return $data;
}

function sql_last_id() 
{
	return mysql_last_insert_id();
}

function sql_sanitize(&$data)
{
	if (!is_array($data))
	{
		$data = mysql_real_escape_string($data);
	}
	
	foreach ($data as $element)
	{
		sql_sanitize($element);
	}
}

?>