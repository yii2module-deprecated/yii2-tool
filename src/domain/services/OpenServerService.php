<?php

namespace yii2module\tool\domain\services;

use yii2lab\domain\services\BaseService;

/**
 * Class OpenServerService
 *
 * @package yii2module\tool\domain\services
 *
 * @property \yii2module\tool\domain\repositories\file\OpenServerRepository $repository
 */
class OpenServerService extends BaseService {
	
	public function update() {
		$collection = $this->repository->scan();
		$this->repository->saveToConfig($collection);
		return $collection;
	}
	
	public function all() {
		$collection = $this->repository->all();
		return $collection;
	}
	
}
