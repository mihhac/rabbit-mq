<?php

namespace Brofist\RabbitMq\Exchange;

use Brofist\RabbitMq\Client\Client;
use Brofist\RabbitMq\Client\ClientAwareTrait;

abstract class AbstractExchange
{
    use ClientAwareTrait;

    const EXCHANGE_TYPE_DIRECT = 'direct';
    const EXCHANGE_TYPE_FANOUT = 'fanout';
    const EXCHANGE_TYPE_HEADERS = 'headers';
    const EXCHANGE_TYPE_TOPIC = 'topic';

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $type;

    public function __construct(Client $client, string $name)
    {
        $this->setClient($client);
        $this->name = $name;
    }

    public function declareExchange()
    {
        $this->client->getChannel()->exchange_declare($this->name, $this->type, false, true, false);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): string
    {
        return $this->type;
    }
}
