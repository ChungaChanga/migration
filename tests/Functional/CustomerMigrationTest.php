<?php

namespace App\Tests\Functional;

use App\Connector\Memory\Connector\CustomerConnector;
use App\Migration\Migration;
use App\Migration\MigrationState;
use App\TransferStrategy\CustomerTransferStrategy;
use Chungachanga\AbstractMigration\Connection\Connection;
use Chungachanga\AbstractMigration\EntityHandler\BaseHandler;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CustomerMigrationTest extends KernelTestCase
{
//    public function testEntityCount()
//    {
//        $sourceConnector = new CustomerConnector();
//        $destinationConnector = new CustomerConnector();
//        $sourceConnector->getRepository()->create($this->getSixCustomers());
//        $connection = new Connection(
//            $sourceConnector,
//            $destinationConnector,
//        );
//
//        $strategy = new CustomerTransferStrategy($destinationConnector);
//
//        $migrationState = new MigrationState(
//            static::class,
//            1,
//            2,
//            3,
//        );
//
//        $migration = new Migration(
//            $connection,
//            $strategy,
//            $migrationState,
//            new BaseHandler()
//        );
//
//        $migration->start();
//
//        $this->assertCount(
//            6,
//            $destinationConnector->getRepository()->fetch(0, 100),
//        );
//    }

    public function testEntityCompare()
    {
        $sourceConnector = new CustomerConnector();
        $destinationConnector = new CustomerConnector();
        $sourceConnector->getRepository()->create($this->getSixCustomers());
        $connection = new Connection(
            $sourceConnector,
            $destinationConnector,
        );

        $strategy = new CustomerTransferStrategy($destinationConnector);

        $migrationState = new MigrationState(
            static::class,
            1,
            2,
            3,
        );

        $migration = new Migration(
            $connection,
            $strategy,
            $migrationState,
            new BaseHandler()
        );

        $migration->start();

        $this->assertEquals(
            'vasya@gmail.com',
            $destinationConnector->getRepository()->fetchPage(1, 3)[2]['email']
        );
    }

    private function getSixCustomers()
    {
        return [
            [
                'id' => 1,
                'email' => 'ivan@gmail.com',
                'firstname' => 'Ivan',
                'lastname' => 'Ivanov',
            ],
            [
                'id' => 2,
                'email' => 'petr@gmail.com',
                'firstname' => 'Petr',
                'lastname' => 'Petrov',
            ],
            [
                'id' => 3,
                'email' => 'vasya@gmail.com',
                'firstname' => 'Vasya',
                'lastname' => 'Vasiliev',
            ],
            [
                'id' => 4,
                'email' => 'kolya@gmail.com',
                'firstname' => 'Kolya',
                'lastname' => 'Kokoko',
            ],
            [
                'id' => 5,
                'email' => 'user1@gmail.com',
                'firstname' => 'user1',
                'lastname' => 'user1last',
            ],
            [
                'id' => 6,
                'email' => 'user2@gmail.com',
                'firstname' => 'user2',
                'lastname' => 'user2last',
            ],
        ];
    }
}