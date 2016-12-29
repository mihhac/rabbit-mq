<?php

namespace Brofist\RabbitMq\QueueTest;

use Brofist\RabbitMq\Client\Client;
use Brofist\RabbitMq\Queue\Queue;
use PhpAmqpLib\Channel\AMQPChannel;
use Prophecy\Prophecy\ObjectProphecy;

class QueueTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Queue
     */
    protected $queue;

    /**
     * @var Client | ObjectProphecy
     */
    protected $client;

    /**
     * @var string
     */
    protected $queueName = 'queue';

    /**
     * @before
     */
    public function initialize()
    {
        $this->client = $this->prophesize(Client::class);
        $this->queue = new Queue($this->client->reveal(), $this->queueName);
    }

    /**
     * @test
     */
    public function canDeclareQueue()
    {
        /**
         * @var AMQPChannel | ObjectProphecy $channel
         */
        $channel = $this->prophesize(AMQPChannel::class);
        $channel->queue_declare($this->queueName, false, true, false, false)->shouldBeCalled();
        $this->client->getChannel()->willReturn($channel->reveal());

        $this->queue->declareQueue();
    }
}
