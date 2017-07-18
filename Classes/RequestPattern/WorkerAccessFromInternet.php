<?php

namespace Netlogix\Aws\ElasticBeanstalk\RequestPattern;

/*
 * This file is part of the Netlogix.Aws.ElasticBeanstalk package.
 */

use Netlogix\Aws\ElasticBeanstalk\Controller\WorkerController;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Mvc\ActionRequest;
use TYPO3\Flow\Mvc\RequestInterface;
use TYPO3\Flow\Security\RequestPatternInterface;
use TYPO3\Flow\Utility\Ip as IpUtility;

class WorkerAccessFromInternet implements RequestPatternInterface
{
	/**
	 * @var array
	 */
	protected $options;

	/**
	 * Expects no options
	 *
	 * @param array $options
	 */
	public function __construct(array $options)
	{
		$this->options = $options;

	}

	/**
	 * Matches a \TYPO3\Flow\Mvc\RequestInterface against its set pattern rules
	 *
	 * @param RequestInterface $request The request that should be matched
	 * @return boolean TRUE if the pattern matched, FALSE otherwise
	 */
	public function matchRequest(RequestInterface $request)
	{
		if (!$request instanceof ActionRequest) {
			return false;
		}

		return $request->getControllerObjectName() === WorkerController::class &&
			!$this->isLocalhost($request->getHttpRequest()->getClientIpAddress());
	}

	/**
	 * Check whether the given IP is a loopback IP
	 *
	 * @param string $ip
	 * @return bool
	 */
	protected function isLocalhost($ip) {
		return IpUtility::cidrMatch($ip, '127.0.0.1/8') || IpUtility::cidrMatch($ip, '::1');
	}
}
