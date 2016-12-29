<?php

namespace Brofist\RabbitMq\ClientTest;

use Brofist\RabbitMq\Client\AbstractWorker;
use Brofist\RabbitMq\Client\Client;
use Prophecy\Prophecy\ObjectProphecy;

class AbstractWorkerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AbstractWorker
     */
    protected $abstractWorker;

    /**
     * @var Client | ObjectProphecy
     */
    protected $client;

    /**
     * @before
     */
    public function initialize()
    {
        $this->client = $this->prophesize(Client::class)->reveal();

        $this->abstractWorker = new class($this->client) extends AbstractWorker{
        };
    }

    /**
     * @test
     */
    public function canInstantiate()
    {
        $this->assertSame($this->client, $this->abstractWorker->getClient());
    }
}
