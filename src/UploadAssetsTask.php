<?php

namespace SilverStripeAustralia\S3Publisher;

use Guzzle\Http\Mimetypes;

/**
 * Uploads asset files to the bucket.
 */
class UploadAssetsTask extends \BuildTask {

	protected $title = 'Upload S3 Assets';

	protected $description = 'Uploads bucket website assets to S3';

	/**
	 * @var BucketWebsite
	 */
	private $website;

	public function __construct(BucketWebsite $website) {
		$this->website = $website;
		parent::__construct();
	}

	public function run($request) {
		foreach($this->website->getAssetFiles() as $asset) {
			$pathname = $asset->getPathname();
			$key = $pathname;

			if(strpos($key, BASE_PATH) === 0) {
				$key = trim(substr($key, strlen(BASE_PATH)), '/');
			}

			$this->website->upload($key, fopen($pathname, 'r'), array(
				'ContentType' => Mimetypes::getInstance()->fromFilename($asset->getFilename())
			));
		}
	}

}
