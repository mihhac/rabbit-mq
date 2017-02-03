#!/usr/bin/env bash

CURRENT_DIR=$(dirname "$BASH_SOURCE")

docker-compose stop \
    && docker-compose rm -f \
    && source "$CURRENT_DIR/remove_docker_image.sh" \
    && docker-compose build \
    && docker-compose up -d \
    && sleep 20 \

echo "Setup is completed!"
