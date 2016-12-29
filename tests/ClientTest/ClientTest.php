<?php

namespace Brofist\RabbitMq\ClientTest;

use Brofist\RabbitMq\Client\Client;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use Prophecy\Prophecy\ObjectProphecy;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var AMQPStreamConnection | ObjectProphecy
     */
    protected $connection;

    /**
     * @var AMQPChannel | ObjectProphecy
     */
    protected $channel;

    /**
     * @before
     */
    public function initialize()
    {
        $this->channel = $this->prophesize(AMQPChannel::class);

        $this->connection = $this->prophesize(AMQPStreamConnection::class);
        $this->connection->channel()->willReturn($this->channel);

        $this->client = new Client($this->connection->reveal());
    }

    /**
     * @after
     */
    public function finalize()
    {
        //destructor part
        $this->connection->close()->shouldBeCalled();
        $this->channel->close()->shouldBeCalled();
    }

    /**
     * @test
     */
    public function canInstantiate()
    {
        $this->assertEquals($this->connection->reveal(), $this->client->getConnection());
        $this->assertEquals($this->channel->reveal(), $this->client->getChannel());
    }

    /**
     * @test
     */
    public function canDestruct()
    {
        $this->connection->close()->shouldBeCalled();
        $this->channel->close()->shouldBeCalled();

        $this->client->__destruct();
    }
}
