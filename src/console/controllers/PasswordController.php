<?php

namespace yii2module\tool\console\controllers;

use Yii;
use yii2lab\extension\console\base\Controller;
use yii2lab\extension\console\helpers\Output;

/**
 * Password tools
 */
class PasswordController extends Controller
{
	
	/**
	 * Generate random password list
	 */
	public function actionGenerate()
	{
		$passwordList = \App::$domain->tool->password->generate();
		$text = implode(SPC, $passwordList);
		Output::line();
		Output::pipe('Generated passwords');
		Output::autoWrap($text);
		Output::pipe();
		Output::line();
	}
	
}
