<?php

namespace SilverStripeAustralia\S3Publisher;

use Aws\S3\S3Client;
use SilverStripe\Framework\Injector\Factory;

/**
 * A factory which creates new {@link BucketWebsite} instances from configuration parameters.
 */
class BucketWebsiteFactory implements Factory {

	public $client;
	public $bucket;

	public function create($service, array $params = array()) {
		return new BucketWebsite(S3Client::factory($this->client), $this->bucket);
	}

}
