<?php

/*
 *	MySQL functions
 */

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
}

function sql_row()
{
	return mysql_fetch_assoc($sql_result);
}

function sql_all()
{
	while ($row = sql_row())
		$data[$n++] = $row;
		
	return $data;
}

?>