<?php

namespace yii2module\tool\console\controllers;

use Yii;
use yii2lab\extension\console\base\Controller;

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
		\App::$domain->tool->grabber->run();
	}
	
}
