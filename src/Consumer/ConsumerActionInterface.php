<?php

namespace Brofist\RabbitMq\Consumer;

interface ConsumerActionInterface
{
    public function consumerActionExecute(string $messageBody);
}
