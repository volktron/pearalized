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
	if (!$result)
		return mysql_fetch_assoc($sql_result);
	return mysql_fetch_assoc($result);
}

function sql_all($result = false)
{
	if	(!$result)
		$result = $sql_result;
		
	while ($row = sql_row($result))
		$data[$n++] = $row;
		
	return $data;
}

function sql_last_id() 
{
	return mysql_last_insert_id();
}

?>