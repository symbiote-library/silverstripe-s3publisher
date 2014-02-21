<?php

namespace SilverStripeAustralia\S3Publisher;

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

			$key = $this->getKeyForURL($url);
			$model = $this->bucket->upload($key, $body);

			$result[$url] = $data + array('path' => $model['ObjectURL']);
		}

		return $result;
	}

	private function getKeyForURL($url) {
		$parts = @parse_url($url);
		$path = isset($parts['path']) ? $parts['path'] : '';

		if(stripos($path, BASE_URL) === 0) {
			$path = substr($path, strlen(BASE_URL));
		}

		$path = trim($path, '/');
		return $path ? "$path.html" : 'index.html';
	}

}
