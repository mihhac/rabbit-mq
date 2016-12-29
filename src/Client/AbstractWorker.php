<?php

namespace Brofist\RabbitMq\Client;

abstract class AbstractWorker
{
    use ClientAwareTrait;

    public function __construct(Client $client)
    {
        $this->setClient($client);
    }
}
