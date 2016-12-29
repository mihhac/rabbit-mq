<?php

namespace Brofist\RabbitMq\BindingTest;

use Brofist\RabbitMq\Binding\ExchangeBinding;
use Brofist\RabbitMq\Client\Client;
use PhpAmqpLib\Channel\AMQPChannel;
use Prophecy\Prophecy\ObjectProphecy;

class ExchangeBindingTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ExchangeBinding
     */
    protected $fixture;

    /**
     * @var Client | ObjectProphecy
     */
    protected $clientMock;

    /**
     * @before
     */
    public function initialize()
    {
        $this->clientMock = $this->prophesize(Client::class);

        $this->fixture = new ExchangeBinding($this->clientMock->reveal());
    }

    /**
     * @test
     */
    public function canBindExchange()
    {
        $destination = 'foo';
        $originExchange = 'bar';
        $routingKey = 'baz';

        /**
         * @var AMQPChannel | ObjectProphecy $channelMock
         */
        $channelMock = $this->prophesize(AMQPChannel::class);
        $channelMock->exchange_bind($destination, $originExchange, $routingKey)->shouldBeCalled();

        $this->clientMock->getChannel()->willReturn($channelMock);

        $this->fixture->bind($destination, $originExchange, $routingKey);
    }
}
