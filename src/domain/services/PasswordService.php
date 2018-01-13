<?php

namespace yii2module\tool\domain\services;

use yii2lab\domain\services\BaseService;
use yii2lab\helpers\Helper;

class PasswordService extends BaseService {
	
	public $length = 9;
	public $set = null;
	public $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	public $count = 105;
	
	public function generate() {
		$passList = [];
		for($i=0;$i<$this->count;$i++) {
			$passList[] = Helper::generateRandomString($this->length, $this->set, $this->characters, true);
		}
		return $passList;
	}
	
}
