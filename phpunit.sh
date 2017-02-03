#!/usr/bin/env bash

IMAGE_NAME=brofist/mq-web:latest

docker-compose stop \
    && docker-compose rm -f \

if [ ! -z $(docker images -q $IMAGE_NAME) ]
then
    echo "Removing previous image $IMAGE_NAME ..."
    docker rmi $IMAGE_NAME
    echo "Image $IMAGE_NAME is removed ..."
else
    echo "Image doesn't exist"
fi

docker-compose build \
    && docker-compose up -d \
    && sleep 20 \
    && docker-compose exec -T mq-web ./vendor/bin/phpunit \

#or simply use docker exec
