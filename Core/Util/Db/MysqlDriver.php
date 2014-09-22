<?php

namespace Core\Util\Db;

class MysqlDriver implements Driver {

	private $db;
	private $query;

	private $host;
	private $username;
	private $password;
	private $databaseName;

	/* DB Connection */
	public function __construct($host, $username, $password, $databaseName) {
		$this->host         = $host;
		$this->username     = $username;
		$this->password     = $password;
		$this->databaseName = $databaseName;
	}
	
	public function setDatabase($database) {
		$this->databaseName = $database;
		mysql_select_db($database, $this->db);
	}
	
	public function closeConnection() {
		if ($this->db) {
			@mysql_close($this->db);
		}
	}
	
	public function hasConnection() {
		return $this->db ? true : false;
	}
	
	public function connect() {
		$this->db = mysql_connect($this->host, $this->username, $this->password);

		if ($this->databaseName) {
			$this->setDatabase($this->databaseName);
		}
	}
	
	public function getDatabase() {
		return $this->databaseName;
	}
	
	public function insertMany($sql, $values, Decorator $db) {
		return $this->query($db->formatSqlforInsertMany($sql, $values));
	}
	
	public function query($query) {
		$query = mysql_query($query);
		if (!$query) {
			throw new Exception($this->getLastError());
		}
		return $query;
	}

	public function begin() {
		mysql_query("SET AUTOCOMMIT=0");
		mysql_query("START TRANSACTION");
	}

	public function commit() {
		mysql_query("COMMIT");
	}

	public function rollback() {
		mysql_query("ROLLBACK");
	}

	public function fetchObject($result) {
		return mysql_fetch_object($result);
	}
	
	public function fetchRow($result) {
		return mysql_fetch_row($result);
	}

	public function getNumRows($result) {
		return mysql_num_rows($result);
	}
	
	public function getAffectedRows() {
		return mysql_affected_rows();	
	}
	
	public function getLastInsertId() {
		return mysql_insert_id();
	}
	
	public function seek($result, $row) {
		return mysql_data_seek($result, $row);
	}
	
	public function freeResult($result) {
		return mysql_free_result($result);
	}
	
	public function getLastError() {
		return mysql_error();
	}
	
	public function escapeString($str) {
		return mysql_real_escape_string($str);
	}
	
	public function getDatabases() {
		return mysql_list_dbs(self::$db);
	}

}
