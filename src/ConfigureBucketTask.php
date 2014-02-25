<?php

namespace SilverStripeAustralia\S3Publisher;

use DataModel;

/**
 * Configures the bucket to serve the website.
 */
class ConfigureBucketTask extends \BuildTask {

	protected $title = 'Configure S3 Bucket';

	protected $description = 'Configures the S3 bucket to serve the static website';

	/**
	 * @var BucketWebsite
	 */
	private $website;

	/**
	 * @var DataModel
	 */
	private $model;

	public function __construct(BucketWebsite $website, DataModel $model) {
		$this->website = $website;
		$this->model = $model;

		parent::__construct();
	}

	public function run($request) {
		echo "Configuring bucket...\n";
		$this->website->configure($this->model);
		echo "Configuration complete\n";
	}

}
