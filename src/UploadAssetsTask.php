<?php

namespace Symbiote\S3Publisher;

use Guzzle\Http\Mimetypes;

/**
 * Uploads asset files to the bucket.
 */
class UploadAssetsTask extends \BuildTask {

	protected $title = 'Upload S3 Bucket Assets';

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
		echo "<p>Uploading assets...\n</p>";
		echo "<ul>\n";

		foreach($this->website->getAssetFiles() as $asset) {
			$pathname = $asset->getPathname();
			$key = $pathname;

			if(strpos($key, BASE_PATH) === 0) {
				$key = trim(substr($key, strlen(BASE_PATH)), '/');
			}

			$this->website->upload($key, fopen($pathname, 'r'), array(
				'ContentType' => Mimetypes::getInstance()->fromFilename($asset->getFilename())
			));

			echo "<li>Uploaded \"$key\"</li>\n";
		}

		echo "</ul>\n";
		echo "<p>Upload complete</p>\n";
	}

}
