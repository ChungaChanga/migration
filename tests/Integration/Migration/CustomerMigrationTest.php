<?php

namespace App\Tests\Integration\Migration;

use App\Connector\Magento\Connector\CustomerConnector as MagentoCustomerConnector;
use App\Connector\Woocommerce\Connector\CustomerConnector as WooCustomerConnector;
use App\Migration\Migration;
use App\Migration\MigrationState;
use App\TransferStrategy\CustomerTransferStrategy;
use Chungachanga\AbstractMigration\Connection\Connection;
use Chungachanga\AbstractMigration\EntityHandler\BaseHandler;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CustomerMigrationTest extends KernelTestCase
{
    public function testMigration()
    {
        self::bootKernel();
        $container = self::getContainer();
        $client = $container->get(HttpClientInterface::class);
        $entityManager = $container->get(EntityManagerInterface::class);

        $sourceConnector = new WooCustomerConnector(
            $client,
            $_ENV['WOOCOMMERCE_API_URL_CUSTOMERS'],
            $_ENV['WOOCOMMERCE_API_KEY'],
            $_ENV['WOOCOMMERCE_API_SECRET']
        );
        $destinationConnector = new MagentoCustomerConnector(
            $client,
            $_ENV['MAGENTO_API_URL_CUSTOMERS']
        );
        $connection = new Connection(
            $sourceConnector,
            $destinationConnector,
        );

        $strategy = new CustomerTransferStrategy($destinationConnector, $entityManager);

        $migrationState = new MigrationState(
            static::class,
            1,
            10,
            2,
        );

        $migration = new Migration(
            $connection,
            $strategy,
            $migrationState,
            new BaseHandler()
        );

        $migration->start();
    }
}