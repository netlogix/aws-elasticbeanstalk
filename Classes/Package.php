<?php

namespace Netlogix\Aws\ElasticBeanstalk;

/*
 * This file is part of the Netlogix.Aws.ElasticBeanstalk package.
 */

use Neos\Flow\Core\Bootstrap;
use Neos\Flow\Package\Package as BasePackage;

class Package extends BasePackage
{
	public function boot(Bootstrap $bootstrap)
	{
		$versionFile = FLOW_PATH_ROOT . '/Version.txt';
		if (file_exists($versionFile)) {
			$version = file_get_contents($versionFile);
			define('DEPLOYMENT_VERSION', $version);
		}

		parent::boot($bootstrap);
	}
}
