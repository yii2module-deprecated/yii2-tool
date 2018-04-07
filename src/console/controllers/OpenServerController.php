<?php

namespace yii2module\tool\console\controllers;

use Yii;
use yii2lab\console\yii\console\Controller;

/**
 * Grabber tools
 */
class OpenServerController extends Controller
{
	
	/**
	 * Grab
	 */
	public function actionRun()
	{
		Yii::$domain->tool->openServer->run();
	}
	
}
