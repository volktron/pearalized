<?php

/*	config.mysql.php
 *	@author Henrik Volckmer
 *
 *	standard sql functions using mysql
 */

// Connect to the database
$sql_link		= mysqli_connect($db_host,$db_user,$db_pass);
if (!$sql_link)
{
	error_log("Can't connect to the database: ".mysqli_error());
}

if (!mysqli_select_db($sql_link,$db_name))
{
	echo "database unavailable";
}

$sql_result 	= 0;
$sql_affected 	= 0;

function sql_query($sql) 
{
	global $sql_link, $sql_result, $sql_affected;
	$sql_result = mysqli_query($sql_link, $sql);
	$sql_affected = mysqli_affected_rows($sql_link);
	
	if (!$sql_result)
	{
		// error handling
		error_log(mysqli_error($sql_link));
	}
	else
	{
		$sql_result;
		return $sql_result;
	}
}

function sql_row($result = false)
{
	global $sql_result;
	if (!$result)
		return mysqli_fetch_assoc($sql_result);
	return mysqli_fetch_assoc($result);
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
	global $sql_link;
	return mysqli_last_insert_id($sql_link);
}

function sql_sanitize(&$data)
{
	global $sql_link;
	if (!is_array($data))
	{
		$data = mysqli_real_escape_string($sql_link, $data);
	}
	
	foreach ($data as $element)
	{
		sql_sanitize($element);
	}
}

?>