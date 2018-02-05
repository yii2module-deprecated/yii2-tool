<?php

namespace yii2module\tool\console\controllers;

use Yii;
use yii2lab\console\yii\console\Controller;

/**
 * Grabber tools
 */
class GrabberController extends Controller
{
	
	/**
	 * Grab
	 */
	public function actionRun()
	{
		Yii::$app->tool->grabber->run();
	}
	
}
