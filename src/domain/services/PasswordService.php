<?php

namespace yii2module\tool\domain\services;

use yii2lab\domain\services\BaseService;
use yii2lab\extension\common\helpers\StringHelper;
use yii2module\tool\domain\enums\CharsetEnum;

class PasswordService extends BaseService {
	
	public $length = 9;
	public $set = null;
	public $characters = CharsetEnum::NUM_ALPHA;
	public $count = 105;
	
	public function generate() {
		$passList = [];
		for($i=0;$i<$this->count;$i++) {
			$passList[] = StringHelper::generateRandomString($this->length, $this->set, $this->characters, true);
		}
		return $passList;
	}
	
}
