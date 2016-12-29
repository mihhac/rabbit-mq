#!/usr/bin/env bash

docker-compose build \
    && docker-compose stop \
    && docker-compose rm -f \
    && docker-compose up -d \
    && sleep 5 \
    && docker-compose exec mq-web ./vendor/bin/phpunit \
    && exit
