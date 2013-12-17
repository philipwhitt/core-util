<?php

namespace Core\Util\Db;

class Iterator implements \Iterator, \ArrayAccess {

	private $driver;

	private $results = null;
	private $index   = 0;
	private $numRows = 0;
	private $errors  = array();

	public function __construct(Driver $driver, $results) {
		if (is_resource($results)) {
			$this->driver  = $driver;
			$this->results = $results;
			$this->numRows = $this->driver->getNumRows($this->results);
		} else {
			throw new Exception("Expected Database Result");
		}
	}

	public function rewind() {
		$this->index = 0;
	}
	public function current() {
		$this->seekTo($this->index);
		return $this->driver->fetchObject($this->results);
	}
	public function key() {
		return $this->index;
	}
	public function next() {
		$this->index++;
	}
	public function valid() {
		return $this->index < $this->numRows;
	}
	private function seekTo($index) {
		return $this->driver->seek($this->results, $index);
	}
	public function length() {
		return $this->count();
	}
	public function count() {
		return $this->numRows;
	}
	public function offsetSet($offset, $value) {
		throw new Exception("Cannot set");
	}
	public function offsetUnset($offset) {
		throw new Exception("Cannot unset");
	}
	public function offsetExists($offset) {
		return $offset < $this->numRows;
	}
	public function offsetGet($offset) {
		$this->index = $offset;
		if ($this->valid()) {
			return $this->current();
		} else {
			throw new Exception("Out Of Bounds: " . $offset);
		}
	}
	public function __destruct() {
		$this->driver->freeResult($this->results);
	}
}
