<?php
namespace Netlogix\Aws\ElasticBeanstalk\Cache\Backend;

/*
 * This file is part of the Netlogix.Aws.ElasticBeanstalk package.
 */

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Persistence\Exception as PersistenceException;

/**
 * @Flow\Proxy(false)
 */
class PdoBackend extends \Neos\Flow\Cache\Backend\PdoBackend
{

	public function setupCache()
	{
		if ($this->pdoDriver === 'mysql') {
			if ($this->databaseHandle->query('SHOW TABLES LIKE \'cache\';')->fetch() === false) {
				$this->createCacheTables();
			}
		} elseif ($this->pdoDriver === 'pgsql') {
			if ($this->databaseHandle->query('SELECT count(*) FROM pg_catalog.pg_tables WHERE schemaname = "cache";')->fetchColumn() === 0) {
				$this->createCacheTables();
			}
		}
	}


}
