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
	
	protected function connect_pdo()
	{
		// PDO
		$pdo_config = array_merge(array(
			'type'		=> 'pdo',
			'driver'	=> 'mysql'
		),
		$this->db_config);
		
		$this->pdo = p('datasource')->setup($pdo_config);
		
	}
	
	protected function connect_mysqli()
	{
		$mysqli_config = array_merge(array(
			'type'		=> 'mysqli'
		),
		$this->db_config);
		
		$this->mysqli = p('datasource')->setup($mysqli_config);		
	}
	
	protected function connect_mysql()
	{
		$mysql_config = array_merge(array(
			'type'		=> 'mysql'
		),
		$this->db_config);
		
		$this->mysql = p('datasource')->setup($mysql_config);
	}
	
	public function test_connect()
	{
		// PDO
		$this->connect_pdo();
		$data = $this->pdo->execute("select 'hello world' hello")->fetch_row();
		$this->assertEquals("hello world",$data['hello']);
		
		// MySQLi
		$this->connect_mysqli();
		$data = $this->mysqli->execute("select 'hello world' hello")->fetch_row();
		$this->assertEquals("hello world",$data['hello']);
		
		// MySQL
		$this->connect_mysql();
		$data = $this->mysql->execute("select 'hello world' hello")->fetch_row();
		$this->assertEquals("hello world",$data['hello']);
	}
	
	public function test_valid_statements()
	{
		$sql_create = <<<SQL
			CREATE TABLE `test`.`test` (
				`id` INT NOT NULL AUTO_INCREMENT ,
				`name` VARCHAR(45) NULL ,
				PRIMARY KEY (`id`) );
SQL;
		$sql_drop = <<<SQL
			DROP TABLE `test`.`test`;
SQL;

		$sql_count_tables = <<<SQL
			SELECT 
				count(*) tables 
			FROM 
				information_schema.tables 
			WHERE table_schema = "test"
SQL;
	
		$sql_inserts = <<<SQL
			INSERT INTO
				`test`.`test`
				(name)
			VALUES
				("Monica"),
				("Erica"),
				("Rita"),
				("Tina"),
				("Sandra"),
				("Mary")
SQL;
	
		$sql_insert_one = <<<SQL
			INSERT INTO
				`test`.`test`
				(name)
			VALUES
				("Jessica")
SQL;

		$sql_count_records = <<<SQL
			SELECT
				count(*) records
			FROM
				`test`.`test`
SQL;

		$sql_retrieve_records = <<<SQL
			SELECT
				*
			FROM
				`test`.`test`
SQL;
		/*******
		 * PDO *
		 *******/
		$this->connect_pdo();
		
		// Test table creation
		$this->pdo->execute($sql_create);
		$data = $this->pdo->execute($sql_count_tables)->fetch_row();
		$this->assertEquals(1,$data['tables']);
		
		// Test inserting multiple records
		$this->pdo->execute($sql_inserts);
		$data = $this->pdo->execute($sql_count_records)->fetch_row();
		$this->assertEquals(6,$data['records']);
		
		// Test retrieving multiple records
		$data = $this->pdo->execute($sql_retrieve_records)->fetch_all();
		$this->assertEquals(6,count($data));
		
		// Test inserting one record, then retrieving the last insert id
		$this->pdo->execute($sql_insert_one);
		$this->assertEquals(7,$this->pdo->last_insert_id());
		
		// Drop the table, confirm drop.
		$this->pdo->execute($sql_drop);
		$data = $this->pdo->execute($sql_count_tables)->fetch_row();
		$this->assertEquals(0,$data['tables']);
		
		/**********
		 * MySQLi *
		 **********/
		$this->connect_mysqli();
		
		// Test table creation
		$this->mysqli->execute($sql_create);
		$data = $this->mysqli->execute($sql_count_tables)->fetch_row();
		$this->assertEquals(1,$data['tables']);
		
		// Test inserting multiple records
		$this->mysqli->execute($sql_inserts);
		$data = $this->mysqli->execute($sql_count_records)->fetch_row();
		$this->assertEquals(6,$data['records']);
		
		// Test retrieving multiple records
		$data = $this->mysqli->execute($sql_retrieve_records)->fetch_all();
		$this->assertEquals(6,count($data));
		
		// Test inserting one record, then retrieving the last insert id
		$this->mysqli->execute($sql_insert_one);
		$this->assertEquals(7,$this->mysqli->last_insert_id());
		
		// Drop the table, confirm drop.
		$this->mysqli->execute($sql_drop);
		$data = $this->mysqli->execute($sql_count_tables)->fetch_row();
		$this->assertEquals(0,$data['tables']);

		/*********
		 * MySQL *
		 *********/
		$this->connect_mysql();
		
		// Test table creation
		$this->mysql->execute($sql_create);
		$data = $this->mysql->execute($sql_count_tables)->fetch_row();
		$this->assertEquals(1,$data['tables']);
		
		// Test inserting multiple records
		$this->mysql->execute($sql_inserts);
		$data = $this->mysql->execute($sql_count_records)->fetch_row();
		$this->assertEquals(6,$data['records']);
		
		// Test retrieving multiple records
		$data = $this->mysql->execute($sql_retrieve_records)->fetch_all();
		$this->assertEquals(6,count($data));
		
		// Test inserting one record, then retrieving the last insert id
		$this->mysql->execute($sql_insert_one);
		$this->assertEquals(7,$this->mysql->last_insert_id());
		
		// Drop the table, confirm drop.
		$this->mysql->execute($sql_drop);
		$data = $this->mysql->execute($sql_count_tables)->fetch_row();
		$this->assertEquals(0,$data['tables']);
	}
}

?>