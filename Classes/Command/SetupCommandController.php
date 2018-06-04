<?php
namespace Netlogix\AWS\ElasticBeanstalk\Command;

/*
 * This file is part of the Netlogix.Aws.ElasticBeanstalk package.
 */

use Netlogix\Aws\ElasticBeanstalk\Cache\Backend\PdoBackend;
use Neos\Flow\Annotations as Flow;
use Neos\Flow\Cache\CacheManager;
use Neos\Flow\Cli\CommandController;

class SetupCommandController extends CommandController
{

	/**
	 * @var CacheManager
	 * @Flow\Inject
	 */
	protected $cacheManager;

	public function cacheCommand()
	{
		foreach ($this->cacheManager->getCacheConfigurations() as $name => $cacheConfiguration) {
			if (isset($cacheConfiguration['backend']) && $cacheConfiguration['backend'] === PdoBackend::class) {
				$cacheBackend = $this->cacheManager->getCache($name)->getBackend();
				if ($cacheBackend instanceof PdoBackend) {
					$cacheBackend->setupCache();
				}
			}
		}
	}
}
