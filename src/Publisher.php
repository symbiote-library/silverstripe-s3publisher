<?php

namespace SilverStripeAustralia\S3Publisher;

use Config;
use Convert;
use Director;

/**
 * A static publish queue compatible extension which publishes the website to a bucket.
 */
class Publisher extends \DataExtension {

	/**
	 * @var BucketWebsite
	 */
	private $bucket;

	public function __construct(BucketWebsite $bucket) {
		$this->bucket = $bucket;
		parent::__construct();
	}

	public function publishPages(array $urls) {
		$result = array();

		Config::nest();

		if(($baseURL = $this->bucket->getBaseURL()) !== null) {
			Config::inst()->update('Director', 'alternate_base_url', $baseURL);
		}

		foreach($urls as $url) {
			try {
				$response = Director::test($url);
			} catch(\SS_HTTPResponse_Exception $e) {
				$response = $e->getResponse();
			}

			$data = array(
				'statuscode' => $response->getStatusCode(),
				'redirect' => null
			);

			if(substr($response->getStatusCode(), 0, 1) == '3') {
				$data['redirect'] = $response->getHeader('Location');

				$body = sprintf(
					'<meta http-equiv="refresh" content="0; URL=%s">',
					Convert::raw2htmlatt(Director::absoluteURL($data['redirect']))
				);
			} else {
				$body = $response->getBody();
			}

			$model = $this->bucket->upload($this->getKeyForURL($url), $body, array(
				'ContentType' => $response->getHeader('Content-Type')
			));

			$result[$url] = $data + array('path' => $model['ObjectURL']);
		}

		Config::unnest();

		return $result;
	}

	private function getKeyForURL($url) {
		$path = parse_url($url, PHP_URL_PATH);

		if(stripos($path, BASE_URL) === 0) {
			$path = substr($path, strlen(BASE_URL));
		}

		return ($path = trim($path, '/')) ? "$path.html" : 'index.html';
	}

}
