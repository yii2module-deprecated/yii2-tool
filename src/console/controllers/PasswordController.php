<?php

namespace yii2module\tool\console\controllers;

use Yii;
use yii2lab\console\yii\console\Controller;
use yii2lab\console\helpers\Output;

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
		$passwordList = Yii::$app->tool->password->generate();
		$text = implode(SPC, $passwordList);
		Output::line();
		Output::pipe('Generated passwords');
		Output::autoWrap($text);
		Output::pipe();
		Output::line();
	}
	
}
