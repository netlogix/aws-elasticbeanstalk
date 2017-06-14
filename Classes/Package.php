<?php

namespace Netlogix\Aws\ElasticBeanstalk;

/*
 * This file is part of the Netlogix.Aws.ElasticBeanstalk package.
 */

use TYPO3\Flow\Core\Bootstrap;
use TYPO3\Flow\Package\Package as BasePackage;

class Package extends BasePackage
{
	const VERSION_PATH = FLOW_PATH_TEMPORARY . 'Version.txt';

	public function boot(Bootstrap $bootstrap)
	{
		if (file_exists(self::VERSION_PATH)) {
			$version = file_get_contents(self::VERSION_PATH);
			define('DEPLOYMENT_VERSION', $version);
		}

		parent::boot($bootstrap);
	}
}
