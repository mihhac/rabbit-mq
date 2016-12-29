<?php

namespace Brofist\RabbitMq\Binding;

class QueueBinding extends AbstractBinding
{
    public function bind(string $destination, string $originExchange, string $routingKey = '')
    {
        $this->client->getChannel()->queue_bind($destination, $originExchange, $routingKey);
    }
}
