<?php

namespace Brofist\RabbitMq\BindingTest;

use Brofist\RabbitMq\Binding\AbstractBinding;
use Brofist\RabbitMq\Client\Client;

class AbstractBindingTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AbstractBinding
     */
    protected $fixture;

    /**
     * @var Client
     */
    protected $clientMock;

    /**
     * @before
     */
    public function initialize()
    {
        $this->clientMock = $this->prophesize(Client::class)->reveal();

        $this->fixture = new class($this->clientMock) extends AbstractBinding {
            public function bind(string $destination, string $originExchange, string $routingKey = '')
            {
            }
        };
    }

    /**
     * @test
     */
    public function canInstantiate()
    {
        $this->assertSame($this->clientMock, $this->fixture->getClient());
    }
}
