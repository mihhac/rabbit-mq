<?php

namespace Brofist\RabbitMq\Binding;

class ExchangeBinding extends AbstractBinding
{
    public function bind(string $destination, string $originExchange, string $routingKey = '')
    {
        $this->client->getChannel()->exchange_bind($destination, $originExchange, $routingKey);
    }
}
