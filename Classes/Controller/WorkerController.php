<?php

namespace Netlogix\Aws\ElasticBeanstalk\Controller;

/*
 * This file is part of the Netlogix.Aws.ElasticBeanstalk package.
 */

use Flowpack\JobQueue\Common\Job\JobInterface;
use Flowpack\JobQueue\Common\Queue\Message;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Core\Booting\Scripts;
use TYPO3\Flow\Mvc\Controller\ActionController;
use TYPO3\Flow\Utility\Algorithms;

class WorkerController extends ActionController
{

	protected $supportedMediaTypes = ['application/json'];

	/**
	 * @var array
	 * @Flow\InjectConfiguration(package="TYPO3.Flow")
	 */
	protected $flowSettings;

	/**
	 * Executes the given job
	 *
	 * @param string $payload The message payload
	 * @param string $queue Queue used to execute the job on. For most jobs the queue implementation is irrelevant.
	 * @return string
	 * @throws \Exception
	 */
	public function commandAction($payload, $queue = 'awseb-fakequeue')
	{
		$job = unserialize($payload);
		if ($job instanceof JobInterface) {
			$receiveCount = 0;
			if ($this->request->getHttpRequest()->hasHeader('X-aws-sqsd-receive-count')) {
				$receiveCount = $this->request->getHttpRequest()->getHeaders()->get('X-aws-sqsd-receive-count');
			}
			$message = new Message(Algorithms::generateUUID(), serialize($job), $receiveCount);
			$result = Scripts::executeCommand('flowpack.jobqueue.common:job:execute', $this->flowSettings, true, [
				$queue,
				base64_encode(serialize($message))
			]);
			if ($result) {
				return '';
			} else {
				throw new \Exception('Job execution failed', 1500368045);
			}
		} else {
			throw new \Exception('Not a valid Job', 1501078167);
		}
	}

}
