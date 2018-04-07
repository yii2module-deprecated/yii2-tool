<?php

namespace yii2module\tool\console\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii2lab\console\helpers\Output;
use yii2lab\console\yii\console\Controller;

/**
 * Open server tools
 */
class OpenServerController extends Controller
{
	
	/**
	 * Update domains config
	 */
	public function actionUpdate()
	{
		$collection = Yii::$domain->tool->openServer->update();
		$hosts = ArrayHelper::getColumn($collection, 'host');
		Output::items($hosts, count($collection) . ' hosts');
		Output::line();
	}
	
	public function actionAll()
	{
		$collection = Yii::$domain->tool->openServer->all();
		$hosts = ArrayHelper::getColumn($collection, 'host');
		Output::items($hosts, count($collection) . ' hosts');
		Output::line();
	}
	
}