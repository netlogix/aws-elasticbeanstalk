<?php

namespace Netlogix\Aws\ElasticBeanstalk;

/*
 * This file is part of the Netlogix.Aws.ElasticBeanstalk package.
 */

use TYPO3\Flow\Core\Bootstrap;
use TYPO3\Flow\Package\Package as BasePackage;

class Package extends BasePackage
{
	public function boot(Bootstrap $bootstrap)
	{
		$versionFile = 'Version.txt';
		if (file_exists($versionFile)) {
			$version = file_get_contents($versionFile);
			define('DEPLOYMENT_VERSION', $version);
		}

		parent::boot($bootstrap);
	}
}
