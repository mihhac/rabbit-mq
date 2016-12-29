#!/usr/bin/env bash

docker-compose build \
    && docker-compose stop \
    && docker-compose rm -f \
    && docker-compose up -d \
    && sleep 5 \
    && docker-compose exec -T mq-web ./vendor/bin/phpunit \

#or simply use docker exec
