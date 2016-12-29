<?php

namespace Brofist\RabbitMq\Binding;

use Brofist\RabbitMq\Client\Client;
use Brofist\RabbitMq\Client\ClientAwareTrait;

abstract class AbstractBinding
{
    use ClientAwareTrait;

    public function __construct(Client $client)
    {
        $this->setClient($client);
    }

    abstract public function bind(string $destination, string $originExchange, string $routingKey = '');
}
