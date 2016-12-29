<?php

namespace Brofist\RabbitMq\Client;

use PhpAmqpLib\Connection\AMQPStreamConnection;

class ClientFactory
{
    protected function validateOptions(array $options)
    {
        $requiredParameters = [
            'host',
            'port',
            'username',
            'password',
        ];

        if (!empty(array_diff($requiredParameters, array_keys($options)))) {
            throw new \DomainException('Cannot create queue client, some parameters are missing!');
        }
    }

    public function create(array $options) : Client
    {
        $this->validateOptions($options);

        $connection = new AMQPStreamConnection(
            $options['host'],
            $options['port'],
            $options['username'],
            $options['password'],
            $options['vhost'] ?? '/'
        );

        $client = new Client($connection);
        return $client;
    }
}
