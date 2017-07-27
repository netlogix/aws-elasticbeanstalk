<?php
namespace Netlogix\Aws\ElasticBeanstalk\Job;

/*
 * This file is part of the Netlogix.Aws.ElasticBeanstalk package.
 */

use Flowpack\JobQueue\Common\Job\JobInterface;
use Flowpack\JobQueue\Common\Queue\Message;
use Flowpack\JobQueue\Common\Queue\QueueInterface;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Core\Booting\Scripts;

/**
 * A Job used to execute Flow commands
 */
class ExecuteCommandJob implements JobInterface
{

	/**
	 * @Flow\InjectConfiguration(package="TYPO3.Flow")
	 * @var array
	 */
	protected $flowSettings;

	/**
	 * @var string
	 */
	protected $command;

	/**
	 * @var array
	 */
	protected $arguments;

	public function __construct($command, array $arguments = [])
	{
		$this->command = $command;
		$this->arguments = $arguments;
	}

	/**
	 * @inheritdoc
	 */
	public function execute(QueueInterface $queue, Message $message)
	{
		return Scripts::executeCommand($this->command, $this->flowSettings, false, $this->arguments);
	}

	/**
	 * @inheritdoc
	 */
	public function getLabel()
	{
		return sprintf('CLI command "%s"', $this->command);
	}

}