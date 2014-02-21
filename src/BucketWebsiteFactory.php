<?php

namespace SilverStripeAustralia\S3Publisher;

use Aws\S3\S3Client;
use SilverStripe\Framework\Injector\Factory;

/**
 * A factory which creates new {@link BucketWebsite} instances from configuration parameters.
 */
class BucketWebsiteFactory implements Factory {

	private $key;
	private $secret;
	private $bucket;

	public function __construct($key, $secret, $bucket) {
		$this->key = $key;
		$this->secret = $secret;
		$this->bucket = $bucket;
	}

	public function create($service, array $params = array()) {
		$client = S3Client::factory(array(
			'key' => $this->key,
			'secret' => $this->secret
		));

		return new BucketWebsite($client, $this->bucket);
	}

}
