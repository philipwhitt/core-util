<?php

namespace Core\Util\Model;

class ObjectMapper {

	public function getEncoded($model) {
		$props = array();

		$reflect = new \ReflectionClass($model);

		foreach ($reflect->getProperties() as $prop) {
			$prop->setAccessible(true);
			$props[$prop->getName()] = $prop->getValue($model);
		}

		return $props;
	}

	public function getFromEncoded(array $params, $model) {
		$reflect = new \ReflectionClass($model);

		foreach ($reflect->getProperties() as $prop) {
			$prop->setAccessible(true);
			$prop->setValue($model, $params[$prop->getName()]);
		}

		return $model;
	}

	public function getJsonEncoded($obj) {
		return json_encode($this->getEncoded($obj));
	}

	public function getFromJsonEncoded($json, $model) {
		return $this->getFromEncoded(json_decode($json, true), $model);
	}

	public function getAllEncoded(array $objs) {
		$data = array();
		foreach ($objs as $obj) {
			$data[] = $this->getEncoded($obj);
		}
		return $data;
	}

	public function getAllFromEncoded(array $objs, $model) {
		$data = array();
		foreach ($objs as $obj) {
			$toModel = clone $model;
			$data[] = $this->getFromEncoded($obj, $toModel);
		}
		return $data;
	}

}