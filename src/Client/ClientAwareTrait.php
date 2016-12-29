<?php

namespace Brofist\RabbitMq\Client;

trait ClientAwareTrait
{
    /**
     * @var Client
     */
    protected $client;

    public function getClient(): Client
    {
        return $this->client;
    }

    public function setClient(Client $client)
    {
        $this->client = $client;
    }
}
