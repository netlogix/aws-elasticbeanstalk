#!/usr/bin/env bash

DIST_NAME="${DIST_NAME:-$(basename $(command cd "$(dirname "${BASH_SOURCE[0]}")" && pwd | sed -E 's~(^|/)Packages/Application/Netlogix.Aws.ElasticBeanstalk/Scripts~~'))}"
VERSION="${VERSION:-$(date +%Y%m%d%H%M%S)}"
ZIP="${ZIP:-${DIST_NAME}-${VERSION}.zip}"

echo "Packaging ${DIST_NAME}..."

# Create source bundle with relevant files
# Exclude development files like .git, node_modules and the like
# Exclude files to install during composer install as .ebextensions are not restricted to root level and these files would modify behaviour of ElasticBeanstalk!
zip -r "${ZIP}" .ebextensions/ Build/ Configuration/ flow Packages/ Web/.htaccess Web/index.php Web/healthcheck.php Web/_Resources/.htaccess composer.json composer.lock -x '*.git*' '*node_modules*' '*/Resources/Private/Installer/*'

echo "Created ${ZIP}"
