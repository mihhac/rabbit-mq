<?php

namespace Brofist\RabbitMq\Queue;

use Brofist\RabbitMq\Client\Client;
use Brofist\RabbitMq\Client\ClientAwareTrait;

class Queue
{
    use ClientAwareTrait;

    /**
     * @var string
     */
    protected $queueName;

    public function __construct(Client $client, string $queueName)
    {
        $this->setClient($client);
        $this->queueName = $queueName;
    }

    public function declareQueue()
    {
        $this->client->getChannel()->queue_declare($this->queueName, false, true, false, false);
    }
}
