> ## **IMPORTANT**

> This module is no longer actively maintained, however, if you're interested in adopting it, please let us know!

SilverStripe S3 Publisher Module
================================

Provides a static publish queue compatible publisher which publishes a copy of the site to S3.

Maintainer Contacts
-------------------
*  Andrew Short (<andrew@silverstripe.com.au>)

Installation
------------

Once you have installed the module using Composer, you need to configure the `BucketWebsiteFactory` with your S3
bucket details, and apply the `Publisher` extension to `SiteTree`:

```yaml
Injector:
  Symbiote\S3Publisher\BucketWebsiteFactory:
    properties:
      client:
        key: "<key>"
        secret: "<secret>"
      bucket: "<bucket>"
      baseURL: "<website-base-url>"

SiteTree:
  extensions:
    - Symbiote\S3Publisher\Publisher
```

You can then run the static publish queue, and it will publish the site to your S3 bucket as static HTML files. There
are also two build tasks:

* `ConfigureBucketTask` configures the S3 bucket to serve the website.
* `UploadAssetsTask` uploads static asset files (CSS, images...).
