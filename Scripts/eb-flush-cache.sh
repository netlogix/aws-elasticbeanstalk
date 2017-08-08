#!/usr/bin/env bash

set -e
set -u

[ -f /opt/elasticbeanstalk/support/envvars ] || { echo "Fatal. Not on elastic beanstalk." >&2 ; exit 1 ; }

. /opt/elasticbeanstalk/support/envvars

export FLOW_CONTEXT=Production

./flow setup:cache
./flow flow:cache:flush
./flow flow:cache:warmup
php -dmemory_limit=512M ./flow resource:publish --collection static
php -dmemory_limit=512M ./flow resource:publish --collection persistent
