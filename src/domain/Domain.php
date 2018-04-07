<?php

namespace yii2module\tool\domain;

use yii2lab\domain\enums\Driver;
use yii2module\tool\domain\enums\CharsetEnum;

/**
 * Class Domain
 * 
 * @package yii2module\tool\domain
 *
 * @property \yii2module\tool\domain\services\GrabberService $grabber
 * @property \yii2module\tool\domain\services\PasswordService $password
 * @property \yii2module\tool\domain\services\OpenServerService $openServer
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
				'openServer' => [
					'driver' => Driver::FILE,
					'domainDir' => 'C:\OpenServer\domains',
					'domainConfigFile' => 'C:\OpenServer\userdata\profiles\Default_domains.txt',
					'domains' => [
						'js',
						'static',
						'tool',
						'tpl',
						'tpltest',
						'yii',
						'yiitest',
					],
				]
			],
			'services' => [
				'password' => [
					'length' => 9,
					'characters' => CharsetEnum::NUM_ALPHA_SIMPLE,
					'count' => 20,
				],
				'grabber',
				'openServer',
			],
		];
	}

}