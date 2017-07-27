<?php
namespace Netlogix\Aws\ElasticBeanstalk\Command;

/*
 * This file is part of the Netlogix.Aws.ElasticBeanstalk package.
 */

use Flowpack\JobQueue\Common\Job\JobInterface;
use Flowpack\JobQueue\Common\Job\JobManager;
use TYPO3\Flow\Annotations as Flow;

/**
 * @Flow\Scope("singleton")
 */
class JobCommandController extends \TYPO3\Flow\Cli\CommandController
{

	/**
	 * @Flow\Inject
	 * @var JobManager
	 */
	protected $jobManager;

	/**
	 * Creates and schedules a new Job
	 *
	 * @param string $queue the queue to use for scheduling
	 * @param string $job the class name of the job to schedule
	 * @param string $arguments the constructor arguments of the job to schedule (as json string)
	 */
	public function scheduleCommand($queue, $job, $arguments = null)
	{
		if ($arguments === null && count($this->request->getExceedingArguments()) > 0) {
			$arguments = join('', $this->request->getExceedingArguments());
		}
		$arguments = $arguments === null ? [] : json_decode($arguments, true);

		if (count($arguments) === 0) {
			$job = new $job();
		} else {
			// TODO: use splat operator instead of ReflectionClass
			$reflectionClass = new \ReflectionClass($job);
			$job = $reflectionClass->newInstanceArgs($arguments);
		}

		if (!($job instanceof JobInterface)) {
			$this->outputLine('Job could not be created.');
			$this->sendAndExit(1);
		}

		$this->jobManager->queue($queue, $job);
		$this->outputLine('Job was successfully queued.');
	}

}
