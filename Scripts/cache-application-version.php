<?php

/*
 * This file is part of the Netlogix.Aws.ElasticBeanstalk package.
 */

const MANIFEST_PATH = '/opt/elasticbeanstalk/deploy/manifest';
const CACHE_PATH = 'Version.txt';

if (file_exists(MANIFEST_PATH)) {
	$manifestJson = file_get_contents(MANIFEST_PATH);
	if ($manifestJson !== false) {
		$manifest = json_decode($manifestJson, true);
		if ($manifest !== false) {
			if (array_key_exists('VersionLabel', $manifest)) {
				$versionLabel = $manifest['VersionLabel'];
				file_put_contents(CACHE_PATH, $versionLabel);
			}
		}
	}
}
