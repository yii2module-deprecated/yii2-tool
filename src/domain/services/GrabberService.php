<?php

namespace yii2module\tool\domain\services;

use yii\httpclient\Client;
use yii2lab\app\domain\helpers\EnvService;
use yii2lab\extension\console\helpers\Output;
use yii2lab\domain\services\BaseService;
use yii2lab\extension\yii\helpers\FileHelper;
use yii2lab\extension\web\enums\HttpMethodEnum;

class GrabberService extends BaseService {
	
	private $links = [];
	
	public function run() {
		$baseUri = 'guide';
		$url = 'guide';
		$this->load([$url], $baseUri);
	}
	
	private function getLinkss($content, $baseUri) {
		$links = $this->getLinks($content);
		$links = preg_grep('#^\/'.preg_quote($baseUri).'#', $links);
		return $links;
	}
	
	private function load($links, $baseUri) {
		if(empty($links)) {
			return;
		}
		foreach($links as $url) {
			$url = trim($url, SL);
			$file = !empty($url) ? $url : 'index';
			$fileName = ROOT_DIR . '/grabber/'.$file.'.html';
			if(!in_array($url, $this->links)) {
				$this->links[] = $url;
				Output::line($fileName);
				$content = $this->getContent($url);
				$links1 = $this->getLinkss($content, $baseUri);
				$links2 = $this->linksToLocal($links1);
				$content = str_replace($links1, $links2, $content);
				FileHelper::save($fileName, $content);
				$this->load($links1, $baseUri);
			}
		}
	}
	
	private function linksToLocal($links) {
		foreach($links as &$link) {
			$link = trim($link, SL) . DOT . 'html';
		}
		return $links;
	}
	
	private function getContent($url) {
		$url = trim($url, SL);
		$httpClient = new Client();
		$httpClient->baseUrl = EnvService::getUrl(FRONTEND);
		$httpClient->baseUrl = trim($httpClient->baseUrl, SL);
		$request = $httpClient->createRequest();
		$request
			->setMethod(HttpMethodEnum::GET)
			->setUrl($url)
		;
		$response = $request->send();
		$content = $response->content;
		return $content;
	}
	
	private function getLinks($html) {
		$pattern = '~<a href="(.+)"\s*>([^<]+)?</a>~';
		preg_match_all($pattern, $html, $matches);
		$all = array_combine($matches[1], $matches[2]);
		$collection = [];
		foreach($all as $url => $title) {
			if(strpos($url, '://') !== false) {
				continue;
			}
			if(strpos($url, SPC) !== false) {
				$url = explode(SPC, $url)[0];
				$url = trim($url, '""');
				$url = explode('#', $url)[0];
			}
			$collection[] = $url;
			usort($collection, 'sortByLen');
		}
		return $collection;
	}
	
}
