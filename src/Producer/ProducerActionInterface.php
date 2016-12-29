<?php

namespace Brofist\RabbitMq\Producer;

interface ProducerActionInterface
{
    public function producerActionExecute(): string;
}
