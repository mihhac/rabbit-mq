<?php

namespace Brofist\RabbitMq\ConsumerTest;

use Brofist\RabbitMq\Client\Client;
use Brofist\RabbitMq\Consumer\Consumer;
use Brofist\RabbitMq\Consumer\ConsumerActionInterface;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Message\AMQPMessage;
use Prophecy\Prophecy\ObjectProphecy;

class ConsumerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Consumer
     */
    protected $consumer;

    /**
     * @var Client | ObjectProphecy
     */
    protected $client;

    /**
     * @var AMQPChannel | ObjectProphecy $channel
     */
    protected $channel;

    /**
     * @var ConsumerActionInterface | ObjectProphecy
     */
    protected $consumerAction;

    /**
     * @before
     */
    public function initialize()
    {
        $this->client = $this->prophesize(Client::class);
        $this->consumerAction = $this->prophesize(ConsumerActionInterface::class);
        $this->channel = $this->prophesize(AMQPChannel::class);

        $this->consumer = new class($this->client->reveal()) extends Consumer {
            public function getConsumerAction() : ConsumerActionInterface
            {
                return $this->consumerAction;
            }

            public function setConsumerAction(ConsumerActionInterface $consumerAction)
            {
                $this->consumerAction = $consumerAction;
            }
        };
    }

    /**
     * @test
     */
    public function canConsume()
    {
        $queue = 'foo-bar';

        $this->channel->basic_qos(null, 1, null)->shouldBeCalled();
        $this->channel->basic_consume(
            $queue,
            '',
            false,
            false,
            false,
            false,
            [$this->consumer, 'callbackMethod']
        )->shouldBeCalled();

        $this->client->getChannel()->willReturn($this->channel->reveal());

        $this->consumer->consume($this->consumerAction->reveal(), $queue);
        $this->assertSame($this->consumerAction->reveal(), $this->consumer->getConsumerAction());
    }

    /**
     * @test
     */
    public function canExecuteCallBackMethod()
    {
        $deliveryTag = 'tag';
        $body = 'body';

        $this->channel->basic_ack($deliveryTag)->shouldBeCalled();

        /**
         * @var AMQPMessage | ObjectProphecy $message
         */
        $message = $this->prophesize(AMQPMessage::class);
        $message->getBody()->willReturn($body);

        /**
         * @var AMQPMessage $messageObject
         */
        $messageObject = $message->reveal();
        $messageObject->delivery_info['channel'] = $this->channel->reveal();
        $messageObject->delivery_info['delivery_tag'] = $deliveryTag;


        $this->consumerAction->consumerActionExecute($body)->shouldBeCalled();

        $this->consumer->setConsumerAction($this->consumerAction->reveal());
        $this->consumer->callbackMethod($messageObject);
    }
}