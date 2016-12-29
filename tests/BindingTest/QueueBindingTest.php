<?php

namespace Brofist\RabbitMq\BindingTest;

use Brofist\RabbitMq\Binding\QueueBinding;
use Brofist\RabbitMq\Client\Client;
use PhpAmqpLib\Channel\AMQPChannel;
use Prophecy\Prophecy\ObjectProphecy;

class QueueBindingTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var QueueBinding
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

        $this->fixture = new QueueBinding($this->clientMock->reveal());
    }

    /**
     * @test
     */
    public function canBindQueue()
    {
        $destination = 'foo';
        $originExchange = 'bar';
        $routingKey = 'baz';

        /**
         * @var AMQPChannel | ObjectProphecy $channelMock
         */
        $channelMock = $this->prophesize(AMQPChannel::class);
        $channelMock->queue_bind($destination, $originExchange, $routingKey)->shouldBeCalled();

        $this->clientMock->getChannel()->willReturn($channelMock);

        $this->fixture->bind($destination, $originExchange, $routingKey);
    }
}
