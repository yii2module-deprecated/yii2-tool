<?php

namespace yii2module\tool\domain;

/**
 * Class Domain
 * 
 * @package yii2module\tool\domain
 */
class Domain extends \yii2lab\domain\Domain {

	public function config() {
		return [
			'repositories' => [
				'password',
				'grabber',
			],
			'services' => [
				'password',
				'grabber',
			],
		];
	}

}