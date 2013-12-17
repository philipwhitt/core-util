<?php

namespace Core\Util\Db;

interface Driver {

	public function setDatabase($database);
	public function getDatabase();

	public function closeConnection();
	public function connect();
	public function hasConnection();
	
	public function query($sql);

	public function begin();
	public function commit();
	public function rollback();

	public function fetchObject($result);
	public function fetchRow($result);

	public function getNumRows($result);
	public function getAffectedRows();
	public function getLastInsertId();

	public function seek($result, $row);
	public function freeResult($result);
	public function getLastError();

	public function escapeString($str);

}