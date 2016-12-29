<?php

namespace Brofist\RabbitMq\ClientTest;

use Brofist\RabbitMq\Client\Client;
use Brofist\RabbitMq\Client\ClientFactory;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class ClientFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ClientFactory
     */
    protected $factory;

    /**
     * @before
     */
    public function initialize()
    {
        $this->factory = new ClientFactory();
    }

    /**
     * @test
     */
    public function canCreateObject()
    {
        $client = $this->factory->create([
            'host'     => 'mq.brofist',
            'port'     => '5672',
            'username' => 'guest',
            'password' => 'guest',
        ]);

        $this->assertInstanceOf(Client::class, $client);
        $this->assertInstanceOf(AMQPStreamConnection::class, $client->getConnection());
    }

    /**
     * @test
     * @dataProvider requiredFields
     * @expectedException \DomainException
     */
    public function canAlertWhenRequiredFieldIsMissing($field)
    {
        $fields = [
            'host'     => 'foo',
            'port'     => 'bar',
            'username' => 'baz',
            'password' => 'qux',
        ];

        unset($fields[$field]);

        $this->factory->create($fields);
    }

    public function requiredFields()
    {
        return [
            'host' => ['host'],
            ['port'],
            ['username'],
            ['password'],
        ];
    }
}
