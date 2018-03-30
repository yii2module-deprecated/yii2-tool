<?php

namespace yii2module\tool\domain;

use yii2module\tool\domain\enums\CharsetEnum;

/**
 * Class Domain
 * 
 * @package yii2module\tool\domain
 */
class Domain extends \yii2lab\domain\Domain {
	
	/**
	 * @return array
	 */
	public function config() {
		return [
			'repositories' => [
				'password',
				'grabber',
			],
			'services' => [
				'password' => [
					'length' => 9,
					'characters' => CharsetEnum::NUM_ALPHA_SIMPLE,
					'count' => 20,
				],
				'grabber',
			],
		];
	}

}