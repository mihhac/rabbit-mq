#!/usr/bin/env bash

CURRENT_DIR=$(dirname "$BASH_SOURCE")
source "$CURRENT_DIR/config.sh"

if [ -z $IMAGE_NAME ]
then
    echo "IMAGE_NAME has not been set! Skipping ..."
    exit
fi

if [ ! -z $(docker images -q $IMAGE_NAME) ]
then
    echo "Removing previous image $IMAGE_NAME ..."
    docker rmi $IMAGE_NAME
    echo "Image $IMAGE_NAME is removed ..."
else
    echo "Image doesn't exist"
fi
