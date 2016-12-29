<?php

namespace Brofist\RabbitMq\ExchangeTest;

use Brofist\RabbitMq\Client\Client;
use Brofist\RabbitMq\Exchange\AbstractExchange;
use PhpAmqpLib\Channel\AMQPChannel;
use Prophecy\Prophecy\ObjectProphecy;

class AbstractExchangeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AbstractExchange
     */
    protected $abstractExchange;

    /**
     * @var string
     */
    protected $name = 'abstractExchange';

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

        $this->abstractExchange = new class($this->client->reveal(), $this->name) extends AbstractExchange {
        };
    }

    /**
     * @test
     */
    public function canInstantiate()
    {
        $this->assertSame($this->name, $this->abstractExchange->getName());
        $this->assertSame($this->client->reveal(), $this->abstractExchange->getClient());
    }

    /**
     * @test
     */
    public function canDeclareExchange()
    {
        /**
         * @var AMQPChannel | ObjectProphecy $channel
         */
        $channel = $this->prophesize(AMQPChannel::class);
        $channel
            ->exchange_declare($this->name, null, false, true, false)
            ->shouldBeCalled();

        $this->client->getChannel()->willReturn($channel);

        $this->abstractExchange->declareExchange();
    }
}
