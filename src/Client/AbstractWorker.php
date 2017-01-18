<?php

namespace Brofist\RabbitMq\Client;

abstract class AbstractWorker
{
    use ClientAwareTrait;

    public function __construct(Client $client)
    {
        $this->setClient($client);
    }

    public function setPcntlAlarm($seconds = 0)
    {
        declare(ticks=1);
        pcntl_signal(SIGALRM, function () {
            throw new \Exception('connection timeout');
        });

        pcntl_alarm($seconds);
    }

    public function resetPcntlAlarm()
    {
        pcntl_alarm(0);
    }
}
