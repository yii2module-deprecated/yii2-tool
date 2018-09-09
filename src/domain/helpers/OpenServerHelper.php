<?php

namespace yii2module\tool\domain\helpers;

use yii\helpers\ArrayHelper;
use yii2lab\extension\yii\helpers\FileHelper;
use yii2module\tool\domain\entities\OpenServerEntity;

class OpenServerHelper {
	
	const YII_WEB = 'web';
	const YII_PROJECT_LABEL_FILE = 'yii';
	const JS_PROJECT_LABEL_FILE = 'dist' . DS . 'index.html';
	
	public static function all(string $domainConfigFile) : array {
		$code = FileHelper::load($domainConfigFile);
		$lines = explode(PHP_EOL, $code);
		$result = [];
		foreach($lines as $line) {
			$parsed = self::parseLine($line);
			if($parsed) {
				$result[] = $parsed;
			}
		}
		return $result;
	}
	
	private static function parseLine($line) {
		$arr = explode(';', $line);
		if(count($arr) > 1) {
			return [
				'host' => $arr[0],
				'dir' => $arr[1],
			];
		}
		return false;
	}
	
	public static function scan($domains, $domainDir) : array {
		$result = [];
		foreach($domains as $domain) {
			$domainItems = self::scanDomain($domainDir, $domain);
			$result = ArrayHelper::merge($result, $domainItems);
		}
		return $result;
	}
	
	public static function collectionToCode(array $collection) : string {
		$code = '';
		/** @var OpenServerEntity $entity */
		foreach($collection as $entity) {
			$code .= $entity->host . ';' . $entity->dir . PHP_EOL;
		}
		return $code;
	}
	
	private static function scanProject(string $domainDir, string $domain, string $project) : array {
		$path = self::getProjectPath($domainDir, $domain, $project);
		$isYiiProject = self::isProject($path, self::YII_PROJECT_LABEL_FILE);
		$isJsProject = self::isProject($path, self::JS_PROJECT_LABEL_FILE);
		if($isYiiProject) {
			$result = self::yiiProjectConfig($domainDir, $domain, $project);
		} elseif($isJsProject) {
			$result[] = self::projectConfig($domain, $project, 'dist');
		} else {
			$result[] = self::projectConfig($domain, $project);
		}
		return $result;
	}
	
	private static function scanDomain($domainDir, string $domain) : array {
		$baseDir = $domainDir . DS . $domain;
		if(!is_dir($baseDir)) {
			return [];
		}
		$projects = FileHelper::scanDir($baseDir);
		$result = [];
		foreach($projects as $project) {
			$projectDir = $baseDir . DS . $project;
			if(is_dir($projectDir)) {
				$r = OpenServerHelper::scanProject($domainDir, $domain, $project);
				$result = ArrayHelper::merge($result, $r);
			}
		}
		return $result;
	}
	
	private static function yiiProjectConfig(string $domainDir, string $domain, string $project) : array {
		$result = [];
		$path = self::getProjectPath($domainDir, $domain, $project);
		$apps = FileHelper::scanDir($path);
		foreach($apps as $app) {
			$items = self::getYiiAppHosts($domainDir, $domain, $project, $app);
			if($items) {
				$result[] = $items;
			}
		}
		return $result;
	}
	
	private static function getYiiAppHosts(string $domainDir, string $domain, string $project, string $app) : array {
		$path = self::getProjectPath($domainDir, $domain, $project);
		$appPath = $path . DS . $app . DS . self::YII_WEB;
		if(!is_dir($appPath)) {
			return [];
		}
		$item['dir'] = DS . $domain . DS . $project . DS . $app . DS . self::YII_WEB;
		$item['host'] = self::yiiHost($domain, $project, $app);
		return $item;
	}
	
	private static function projectConfig(string $domain, string $project, string $path = null) : array {
		$result = [];
		if($path) {
			$path = DS . $path;
		}
		$result['dir'] = DS . $domain . DS . $project . $path;
		$result['host'] = $project . DOT . $domain;
		return $result;
	}
	
	private static function yiiHost(string $domain,string  $project, string $app) : string {
		if($app == FRONTEND) {
			$host = $project . DOT . $domain;
		} elseif($app == BACKEND) {
			$host = 'admin' . DOT . $project . DOT . $domain;
		} else {
			$host = $app . DOT . $project . DOT . $domain;
		}
		return $host;
	}
	
	private static function isProject(string $path, string $name) : bool {
		return is_file($path . DS . $name);
	}
	
	private static function getProjectPath(string $domainDir, string $domain, string $project) : string {
		$path = $domainDir . DS . $domain . DS . $project;
		return $path;
	}
	
}
