<?php

namespace Symbiote\S3Publisher;

use Aws\S3\S3Client;
use SilverStripe\Framework\Injector\Factory;

/**
 * A factory which creates new {@link BucketWebsite} instances from configuration parameters.
 */
class BucketWebsiteFactory implements Factory {

	public $client;
	public $bucket;
	public $baseURL;

	public function create($service, array $params = array()) {
		$website = new BucketWebsite(S3Client::factory($this->client), $this->bucket);
		$website->setBaseURL($this->baseURL);

		return $website;
	}

}
