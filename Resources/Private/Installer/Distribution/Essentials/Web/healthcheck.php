<?php

/*
 * This script checks if the server running it is basically healthy.
 *
 * The following checks are performed:
 * - Can the webserver execute PHP (otherwise, this script won't be executed)
 * - Is the filesystem writable (webroot, /tmp)
 * - Was some process killed by OOM killer
 */

function testFileSystems()
{
	foreach ([__DIR__, '/tmp'] as $testDirectory) {
		testDirectoryWriteable($testDirectory);
	}

}

function testDirectoryWriteable($directory)
{
	$testFile = $directory . DIRECTORY_SEPARATOR . 'testFile.txt';
	try {
		if (!is_writeable($directory)) {
			throw new Exception(sprintf('Directory %s is not writeable', $directory));
		}
		if (file_exists($testFile)) {
			unlink($testFile);
		}
		$testContent = md5(rand());
		$result = file_put_contents($testFile, $testContent);
		if ($result !== strlen($testContent)) {
			throw new Exception('Could not write expected number of bytes');
		}
		$fileContent = file_get_contents($testFile);
		if ($fileContent !== $testContent) {
			throw new Exception('Test file did not contain expected content');
		}
	} finally {
		if (file_exists($testFile)) {
			unlink($testFile);
		}
	}
}

function checkOom()
{
	exec("dmesg | grep -i 'killed process'", $output, $exitCode);
	if ($exitCode > 1) {
		// grep exits with status 1 if nothing was found
		throw new Exception('Error executing grep');
	}
	if (count($output) > 0) {
		throw new Exception('Found some killed processes');
	}
}

try {
	testFileSystems();
	checkOom();
} catch (Exception $e) {
	header($_SERVER['SERVER_PROTOCOL'] . ' 500 Health check failed', true, 500);
}
