<?php

namespace Brofist\RabbitMq\ProducerTest;

use Brofist\RabbitMq\Client\Client;
use Brofist\RabbitMq\Producer\Producer;
use Brofist\RabbitMq\Producer\ProducerActionInterface;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Message\AMQPMessage;
use Prophecy\Prophecy\ObjectProphecy;

class ProducerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Producer
     */
    protected $producer;

    /**
     * @var Client | ObjectProphecy
     */
    protected $client;

    /**
     * @before
     */
    public function initialize()
    {
        $this->client = $this->prophesize(Client::class);
        $this->producer = new Producer($this->client->reveal());
    }

    /**
     * @test
     */
    public function canPublish()
    {
        $exchange = 'exchange';
        $routingKey = 'key';
        $actionResponse = 'body';
        $message = new AMQPMessage(
            $actionResponse,
            [
                'content_type'  => 'application/json',
                'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT,
            ]
        );

        /**
         * @var AMQPChannel | ObjectProphecy $channel
         */
        $channel = $this->prophesize(AMQPChannel::class);
        $channel->basic_publish($message, $exchange, $routingKey)->shouldBeCalled();

        $this->client->getChannel()->willReturn($channel->reveal());

        /**
         * @var ProducerActionInterface | ObjectProphecy $producerAction
         */
        $producerAction = $this->prophesize(ProducerActionInterface::class);
        $producerAction->producerActionExecute()->willReturn($actionResponse);

        $this->producer->publish($producerAction->reveal(), $routingKey, $exchange);
    }
}
