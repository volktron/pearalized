<?php
/*
 * datasource.test.php
 * @author Henrik Volckmer
 */
 
/**
 * @backupGlobals disabled
 * @backupStaticAttributes disabled
 */

class DatasourceTest extends PHPUnit_Framework_TestCase
{
	protected $db_config = array(
	'host'		=> 'localhost',
	'user'		=> 'root',
	'pass'		=> '',
	'database'	=> 'test');
	
	public function test_connect()
	{
		// PDO
		$pdo_config = array_merge(array(
			'type'		=> 'pdo',
			'driver'	=> 'mysql'
		),
		$this->db_config);
		
		$this->pdo = p('datasource')->setup($pdo_config);
		$data = $this->pdo->execute("select 'hello world' hello")->fetch_row();
		$this->assertEquals("hello world",$data['hello']);
		
		// MySQLi
		$mysqli_config = array_merge(array(
			'type'		=> 'mysqli'
		),
		$this->db_config);
		
		$this->mysqli = p('datasource')->setup($mysqli_config);
		$data = $this->mysqli->execute("select 'hello world' hello")->fetch_row();
		$this->assertEquals("hello world",$data['hello']);
		
		// MySQL
		$mysql_config = array_merge(array(
			'type'		=> 'mysql'
		),
		$this->db_config);
		
		$this->mysql = p('datasource')->setup($mysql_config);
		$data = $this->mysql->execute("select 'hello world' hello")->fetch_row();
		$this->assertEquals("hello world",$data['hello']);
	}
}

?>