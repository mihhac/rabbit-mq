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
            $options['vhost'] ?? '/',
            $options['insist'] ?? false,
            $options['login_method'] ?? 'AMQPLAIN',
            $options['login_response'] ?? null,
            $options['locale'] ?? 'en_US',
            $options['connection_timeout'] ?? 3.0,
            $options['read_write_timeout'] ?? 3.0,
            $options['context'] ?? null,
            $options['keepalive'] ?? true,
            $options['heartbeat'] ?? 1
        );

        $client = new Client($connection);
        return $client;
    }
}
