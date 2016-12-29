<?php

namespace Brofist\RabbitMq\ExchangeTest;

use Brofist\RabbitMq\Client\Client;
use Brofist\RabbitMq\Exchange\TopicExchange;

class TopicExchangeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var TopicExchange
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

        $this->exchange = new TopicExchange($this->client, $this->exchangeName);
    }

    /**
     * @test
     */
    public function canInstantiate()
    {
        $this->assertSame($this->exchangeName, $this->exchange->getName());
        $this->assertSame($this->client, $this->exchange->getClient());
        $this->assertSame(TopicExchange::EXCHANGE_TYPE_TOPIC, $this->exchange->getType());
    }
}
