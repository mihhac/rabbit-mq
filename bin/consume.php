<?php

require_once(__DIR__ . "/../vendor/autoload.php");

$clientFactory = new \Brofist\RabbitMq\Client\ClientFactory();
$client = $clientFactory->create([
    'host'      => 'mq.brofist',
    'port'      => '5672',
    'username'  => 'guest',
    'password'  => 'guest',
]);

$consumeClosure = new class implements \Brofist\RabbitMq\Consumer\ConsumerActionInterface
{
    public function consumerActionExecute(string $messageBody)
    {
        echo $messageBody;
    }
};

$consumer = new \Brofist\RabbitMq\Consumer\Consumer($client);
$consumer->consume($consumeClosure, 'foo-bar');
