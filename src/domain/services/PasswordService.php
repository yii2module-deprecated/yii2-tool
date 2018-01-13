<?php

namespace yii2module\tool\domain\services;

use yii2lab\domain\services\BaseService;
use yii2lab\helpers\Helper;

class PasswordService extends BaseService {
	
	private $length = 9;
	private $set = null;
	private $count = 105;
	
	public function generate() {
		$passList = [];
		for($i=0;$i<$this->count;$i++) {
			$passList[] = Helper::generateRandomString($this->length, $this->set, null, true);
		}
		return $passList;
	}
	
}
