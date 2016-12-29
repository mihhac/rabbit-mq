# RabbitMq adapter #

This RabbitMq adapter helps to easy connect, configure, publish and consume RabbitMq.

### What is this repository for? ###

* Easy connect to RabbitMq server
* Define new queue, or ensure that one exists
* Define new exchange, or ensure that one exists
* Define new binding, or ensure that one exists
* Publish message
* Read message

### How do I test it? ###

* git clone git@github.com:brofist-team/rabbit-mq.git .
* composer install
* docker-compose up -d
* docker exec mq-web php bin/consume.php
* http://localhost:8888/bin/produce.php
* http://localhost:8889  [guest:guest]

* To run phpunit test, simply run ./phpunit.sh

### How to I install it ###

* composer require brofist/rabbit-mq

### Examples ###

* bin/produce.php
* bin/consume.php
