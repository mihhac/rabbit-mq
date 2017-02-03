#!/usr/bin/env bash

CURRENT_DIR=$(dirname "$BASH_SOURCE")

source "$CURRENT_DIR/scripts/setup.sh" \
    && docker-compose exec -T mq-web ./vendor/bin/phpunit \

#or simply use docker exec, it will forward T by default
