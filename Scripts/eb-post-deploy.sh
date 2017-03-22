#!/usr/bin/env bash

set -e
set -u

[ -f /opt/elasticbeanstalk/support/envvars ] || { echo "Fatal. Not on elastic beanstalk." >&2 ; exit 1 ; }

. /opt/elasticbeanstalk/support/envvars

export FLOW_CONTEXT=Production

./flow setup:cache
./flow flow:cache:flush
./flow flow:cache:warmup
./flow resource:publish --collection static
./flow doctrine:migrate
