<?php

namespace yii2module\tool\domain\repositories\file;

use yii\helpers\ArrayHelper;
use yii2lab\domain\data\Query;
use yii2lab\domain\interfaces\repositories\ReadAllInterface;
use yii2lab\domain\repositories\BaseRepository;
use yii2lab\helpers\yii\FileHelper;

class OpenServerRepository extends BaseRepository implements ReadAllInterface {
	
	public $domainDir;
	public $domains;
	public $domainConfigFile;
	
	public function save($collection) {
		$code = $this->generateCode($collection);
		FileHelper::save($this->domainConfigFile, $code);
		return $code;
	}
	
	public function all(Query $query = null) {
		$result = [];
		foreach($this->domains as $domain) {
			$domainItems = $this->scanDomain($domain);
			$result = ArrayHelper::merge($result, $domainItems);
		}
		return $this->forgeEntity($result);
	}
	
	public function count(Query $query = null) {
	
	}
	
	private function generateCode($collection) {
		$code = '';
		foreach($collection as $entity) {
			$code .= $entity->host . ';' . $entity->dir . PHP_EOL;
		}
		return $code;
	}
	
	private function scanDomain($domain) {
		$baseDir = $this->domainDir . DS . $domain;
		if(!is_dir($baseDir)) {
			return false;
		}
		$projects = FileHelper::scanDir($baseDir);
		$result = [];
		foreach($projects as $project) {
			$projectDir = $baseDir . DS . $project;
			if(is_dir($projectDir)) {
				$r = $this->scanProject($domain, $project);
				$result = ArrayHelper::merge($result, $r);
			}
		}
		return $result;
	}
	
	private function scanProject($domain, $project) {
		$isYiiProject = $this->isYiiProject($domain, $project);
		$isJsProject = $this->isJsProject($domain, $project);
		if($isYiiProject) {
			$result = $this->yiiProjectConfig($domain, $project);
		} elseif($isJsProject) {
			$result = $this->projectConfig($domain, $project, 'dist');
		} else {
			$result = $this->projectConfig($domain, $project);
		}
		return $result;
	}
	
	private function isYiiProject($domain, $project) {
		$path = $this->getProjectPath($domain, $project);
		return is_file($path . DS . 'yii');
	}
	
	private function isJsProject($domain, $project) {
		$path = $this->getProjectPath($domain, $project);
		return is_file($path . DS . 'dist' . DS . 'index.html');
	}
	
	private function yiiProjectConfig($domain, $project) {
		$result = [];
		$path = $this->getProjectPath($domain, $project);
		$apps = FileHelper::scanDir($path);
		foreach($apps as $app) {
			$appPath = $path . DS . $app . DS . 'web';
			if(is_dir($appPath)) {
				$item['dir'] = DS . $domain . DS . $project . DS . $app . DS . 'web';
				if($app == FRONTEND) {
					$item['host'] = $project . DOT . $domain;
				} elseif($app == BACKEND) {
				} else {
					$item['host'] = 'admin' . DOT . $project . DOT . $domain;
				}
				$result[] = $item;
			}
		}
		return $result;
	}
	
	private function projectConfig($domain, $project, $path = '') {
		$result = [];
		if(!empty($path)) {
			$path = DS . $path;
		}
		$d['dir'] = DS . $domain . DS . $project . $path;
		$d['host'] = $project . DOT . $domain;
		$result[] = $d;
		return $result;
	}
	
	private function getProjectPath($domain, $project) {
		$path = $this->domainDir . DS . $domain . DS . $project;
		return $path;
	}
}
