#!/usr/bin/env bash

DIST_NAME="${DIST_NAME:-$(basename $(command cd "$(dirname "${BASH_SOURCE[0]}")" && pwd | sed -E 's~(^|/)Packages/Application/Netlogix.Aws.ElasticBeanstalk/Scripts~~'))}"
VERSION="${VERSION:-$(date +%Y%m%d%H%M%S)}"
ZIP="${ZIP:-${DIST_NAME}-${VERSION}.zip}"

echo "Packaging ${DIST_NAME}..."

zip -r "${ZIP}" .ebextensions/ Build/ Configuration/ flow Packages/ Web/.htaccess Web/index.php Web/_Resources/.htaccess composer.json composer.lock -x '*.git*' '*node_modules*'

echo "Created ${ZIP}"
