#!/bin/bash

APP="api_project"
NETWORK_NAME="$APP-network"
HOME="/home/jem/www/api-service"

COMMAND=$1

start_stack() {
    echo "STARTING STACK"
    echo "====== Creating network $NETWORK_NAME ======"
    docker network create -d bridge $NETWORK_NAME


    echo ""
    echo "====== Starting Nginx Container ======"
    docker run \
        --detach \
        --restart unless-stopped \
        --network $NETWORK_NAME \
        --volume $HOME/docker/nginx/conf.d:/etc/nginx/conf.d/ \
        --volume $HOME/vms-comics-api:/var/www/ \
        --publish 0.0.0.0:5000:80/tcp \
        --name $APP-nginx \
        $APP/nginx


    # echo ""
    # echo "Waiting for mysql"
    # while ! mysqladmin ping -h"127.0.0.1" -u pasuyo_user --password="secret" --port=6603 --silent; do
    #     sleep 1
    # done

    echo ""
    echo "====== Starting PHP Container ======"
    docker run \
        --detach \
        --restart unless-stopped \
        --network $NETWORK_NAME \
        --volume $HOME/vms-comics-api:/var/www/ \
        --volume $HOME/docker/php/init.sh:/init.sh \
        --publish 0.0.0.0:9000:9000/tcp \
        --name $APP-php \
        $APP/php-fpm

    # docker run \
    #     --detach \
    #     --link pasuyo_project-mysql \
    #     --restart unless-stopped \
    #     --network $NETWORK_NAME \
    #     --volume $HOME/api:/var/www/ \
    #     --volume $HOME/docker/php/init.sh:/init.sh \
    #     --publish 0.0.0.0:9000:9000/tcp \
    #     --name $APP-php \
    #     $APP/php-fpm

    # echo ""
    # echo "====== Starting Proxy Container ======"
    # docker run \
    #     --detach \
    #     --restart unless-stopped \
    #     --network $NETWORK_NAME \
    #     --volume $HOME/docker/proxy/conf.d:/etc/nginx/conf.d/ \
    #     --publish 0.0.0.0:80:80/tcp \
    #     --name $APP-proxy \
    #     $APP/proxy

    docker ps
}

stop_stack() {
    echo "STOPING STACK"
    docker rm --force $APP-nginx
    docker rm --force $APP-php
    # docker rm --force $APP-frontend
    # docker rm --force $APP-proxy
    # docker rm --force $APP-mysql
    docker network rm $NETWORK_NAME
    docker ps
}

if [ $COMMAND = "start" ]
then
    start_stack
fi

if [ $COMMAND = "stop" ]
then
    stop_stack
fi

if [ $COMMAND = "build"  ]
then
    docker build \
        --tag $APP/php-fpm \
        --build-arg user=luffy \
        --build-arg uid=1000 \
        --target api_project-php .

    echo "Building Nginx image"
    docker build \
        --tag $APP/nginx \
        --target api_project-nginx .

    # echo "Building Node image"
    # docker build \
    #     --target frontend-build-stage .

    # echo "Building nginx for node"
    # docker build \
    #     --tag $APP/frontend \
    #     --target frontend-production-stage .

    # echo "Building Proxy nginx image"
    # docker build \
    #     --tag $APP/proxy \
    #     --target pasuyo_project-proxy .

    echo ""
    echo "Done"
fi
