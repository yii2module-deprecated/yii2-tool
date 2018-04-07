<?php

namespace yii2module\tool\domain\services;

use yii2lab\console\helpers\Output;
use yii2lab\domain\services\BaseService;

/**
 * Class OpenServerService
 *
 * @package yii2module\tool\domain\services
 * @property \yii2module\tool\domain\repositories\file\OpenServerRepository $repository
 */
class OpenServerService extends BaseService {
	
	public function run() {
		$collection = $this->repository->all();
		$this->repository->save($collection);
		Output::block('total: ' . count($collection) . ' domains', 'success!!!');
	}
	
}
