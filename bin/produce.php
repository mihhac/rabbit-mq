<?php

require_once(__DIR__ . "/../vendor/autoload.php");

$clientFactory = new \Brofist\RabbitMq\Client\ClientFactory();
$client = $clientFactory->create([
    'host'      => 'mq.brofist',
    'port'      => '5672',
    'username'  => 'guest',
    'password'  => 'guest',
]);

//configuration
//only needed for first time, if code will ensure setup

$queue = new \Brofist\RabbitMq\Queue\Queue($client, 'foo-bar');
$queue->declareQueue();

$exchange = new \Brofist\RabbitMq\Exchange\DirectExchange($client, 'foo-exchange');
$exchange->declareExchange();

$binding = new \Brofist\RabbitMq\Binding\QueueBinding($client);
$binding->bind('foo-bar', 'foo-exchange', 'foo-bar-key');

//end of configuration

$closure = new class implements \Brofist\RabbitMq\Producer\ProducerActionInterface
{
    public function producerActionExecute(): string
    {
        return json_encode(['createdAt' => date('Y-m-d H:i:s')]);
    }
};

$producer = new \Brofist\RabbitMq\Producer\Producer($client);
$producer->publish($closure, 'foo-bar');
