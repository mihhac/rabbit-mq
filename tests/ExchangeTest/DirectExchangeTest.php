<?php

namespace Brofist\RabbitMq\ExchangeTest;

use Brofist\RabbitMq\Client\Client;
use Brofist\RabbitMq\Exchange\DirectExchange;

class DirectExchangeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DirectExchange
     */
    protected $exchange;

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var string
     */
    protected $exchangeName = 'exchange';

    /**
     * @before
     */
    public function initialize()
    {
        $this->client = $this->prophesize(Client::class)->reveal();

        $this->exchange = new DirectExchange($this->client, $this->exchangeName);
    }

    /**
     * @test
     */
    public function canInstantiate()
    {
        $this->assertSame($this->exchangeName, $this->exchange->getName());
        $this->assertSame($this->client, $this->exchange->getClient());
        $this->assertSame(DirectExchange::EXCHANGE_TYPE_DIRECT, $this->exchange->getType());
    }
}
