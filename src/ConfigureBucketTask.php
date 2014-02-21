<?php

namespace SilverStripeAustralia\S3Publisher;

/**
 * Configures the S3 bucket.
 */
class ConfigureBucketTask extends \BuildTask {

	protected $title = 'Configure Website Bucket Task';

	protected $description = 'Configures the S3 bucket to serve a static copy of the site';

	/**
	 * @var BucketWebsite
	 */
	private $bucket;

	public function __construct(BucketWebsite $bucket) {
		$this->bucket = $bucket;
		parent::__construct();
	}

	public function run($request) {
		$this->bucket->configure();
	}

}
