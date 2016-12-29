#!/usr/bin/env bash

docker-compose build \
    && docker rm -f mq-web \
    && docker-compose up -d \
    && docker-compose exec mq-web ./vendor/bin/phpunit
