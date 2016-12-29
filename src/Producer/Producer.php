<?php

namespace Brofist\RabbitMq\Producer;

use Brofist\RabbitMq\Client\AbstractWorker;
use PhpAmqpLib\Message\AMQPMessage;

class Producer extends AbstractWorker
{
    public function publish(ProducerActionInterface $producerAction, string $routingKeyOrQueue, string $exchange = '')
    {
        $channel = $this->getClient()->getChannel();

        $message = new AMQPMessage(
            $producerAction->producerActionExecute(),
            [
                'content_type'  => 'application/json',
                'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT,
            ]
        );

        $channel->basic_publish($message, $exchange, $routingKeyOrQueue);
    }
}
