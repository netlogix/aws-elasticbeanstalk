<?php

namespace Netlogix\Aws\ElasticBeanstalk\Controller;

/*
 * This file is part of the Netlogix.Aws.ElasticBeanstalk package.
 */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Core\Booting\Scripts;
use TYPO3\Flow\Mvc\Controller\ActionController;

class WorkerController extends ActionController
{

	protected $supportedMediaTypes = ['application/json'];

	/**
	 * @var array
	 * @Flow\InjectConfiguration(package="TYPO3.Flow")
	 */
	protected $flowSettings;

	/**
	 * Executes the given flow command
	 *
	 * @param string $command
	 * @param array $arguments
	 * @return string
	 * @throws \Exception
	 */
	public function commandAction($command, array $arguments = []) {
		if (Scripts::executeCommand($command, $this->flowSettings, true, $arguments)) {
			return '';
		} else {
			throw new \Exception('Command execution failed', 1500368045);
		}
	}
}
