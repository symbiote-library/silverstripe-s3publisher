<?php

namespace SilverStripeAustralia\S3Publisher;

use Aws\S3\S3Client;
use Symfony\Component\Finder\Finder;

/**
 * A bucket to which the website is published.
 */
class BucketWebsite {

	/**
	 * @var S3Client
	 */
	private $client;

	/**
	 * @var string
	 */
	private $bucket;

	public function __construct(S3Client $client, $bucket) {
		$this->client = $client;
		$this->bucket = $bucket;
	}

	/**
	 * @return S3Client
	 */
	public function getClient() {
		return $this->client;
	}

	/**
	 * @return string
	 */
	public function getBucket() {
		return $this->bucket;
	}

	/**
	 * @param string $key
	 * @param mixed $body
	 * @param array $params
	 * @return \Guzzle\Service\Resource\Model
	 */
	public function upload($key, $body, array $params = array()) {
		return $this->client->upload($this->bucket, $key, $body, 'private', array(
			'params' => $params
		));
	}

	/**
	 * Gets the local website asset files, relative to the site root.
	 *
	 * @return \SplFileInfo[]
	 */
	public function getAssetFiles() {
		$finder = new Finder();

		return $finder
			->files()
			->notName('*.ss')
			->in(THEMES_PATH);
	}

}
