<?php

namespace SilverStripeAustralia\S3Publisher;

use Aws\S3\S3Client;

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

	public function configure() {
		return $this->client->putBucketWebsite(array(
			'Bucket' => $this->bucket
		));
	}

	/**
	 * @param string $key
	 * @param mixed $body
	 * @return \Guzzle\Service\Resource\Model
	 */
	public function upload($key, $body) {
		return $this->client->upload($this->bucket, $key, $body);
	}

}