<?php

namespace Core\Util\Db;

class Decorator {
	
	private $driver;
	private $query;
	
	public function __construct(Driver $driver) {
		$this->driver = $driver;
	}
	
	public function query($sql) {
		return $this->driver->query($sql);
	}
	
	public function connect() {
		$this->driver->connect();
	}

	public function closeConnection() {
		$this->driver->closeConnection();
	}

	/* Transaction */
	public function begin() {
		$this->driver->begin();
	}
	public function commit() {
		$this->driver->commit();
	}
	public function rollback() {
		$this->driver->rollback();
	}

	/* Decorators */
	public function select($query, $args = array()) {
		$query = $this->sanitizeSql($query, $args);
		return new Iterator($this->driver, $this->driver->query($query));
	}
	public function selectRecord($query, $args = array()) {
		$query = $this->sanitizeSql($query, $args);
		return $this->returnObject($this->driver->query($query));
	}
	public function insert($query, $args = array()) {
		$query = $this->sanitizeSql($query, $args);
		$this->driver->query($query);
		return $this->driver->getLastInsertId();
	}
	public function insertMany($query, array $values = array()) {
		$resultResource = $this->driver->insertMany($query, $values, $this);
		return $this->driver->getLastInsertId();
	}
	public function update($query, $args = array()) {
		$query = $this->sanitizeSql($query, $args);
		$this->driver->query($query);
		return $this->driver->getAffectedRows();
	}
	public function delete($query, $args = array()) {
		$query = $this->sanitizeSql($query, $args);
		$this->driver->query($query);
		return $this->driver->getAffectedRows();
	}
	public function getErrors() {
		return $this->driver->errors();
	}
	
	private function returnObject($resource) {
		return $this->driver->fetchObject($resource);
	}
	
	public function formatSqlforInsertMany($sql, array $values) {
		$clean = $sql;
		if (count($values) > 0) {
			list($escaped, $valueFormat) = explode('VALUES', $sql);

			$formattedValueArr = array();
			foreach ($values as $set) {
				$formattedValueArr[] = $this->sanitizeSql($valueFormat, $set);
			}
			$clean = $escaped . " VALUES " . implode(", ", $formattedValueArr);
		}
		return $clean;
	}
	
	/* Clean up SQL Variables */
	public function sanitizeSql($sql, array $args) {
		if ($args) {
			$escaped = array_map(array($this, 'sanitizeValue'), $args);
			$format  = preg_replace("/\?/", "%s", $sql); 
			$clean   = vsprintf($format, $escaped);
		} else {
			$clean = $sql;
		}
		return $clean;
	}

	public function sanitizeValue($val) {
		$clean = null;
		if (is_bool($val)) {
			$clean = (int)$val;
		} else if (is_int($val) || is_float($val)) {
			$clean = $val;
		} else if (strtoupper($val) == "IS NOT NULL") {
			$clean = "IS NOT NULL";
		} else if (strtoupper($val) == "IS NULL") {
			$clean = "IS NULL";
		} else if (substr($val, 0, strlen('GeomFromText')) == 'GeomFromText') {
			$clean = $val;
		} else {
			$clean = "'" .$this->driver->escapeString($val). "'";
		}
		return $clean;
	}
}