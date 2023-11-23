<?php

namespace App\Controller;

use App\Connector\Woocommerce\Connector\CustomerConnector as WooCustomerConnector;
use App\Connector\Magento\Connector\CustomerConnector as MagentoCustomerConnector;
use App\Migration\Migration;
use App\Migration\MigrationState;
use App\TransferStrategy\CustomerTransferStrategy;
use Chungachanga\AbstractMigration\Connection\Connection;
use Chungachanga\AbstractMigration\EntityHandler\BaseHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class MigrationController extends AbstractController
{
    #[Route('/migration', name: 'app_migration')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/MigrationController.php',
        ]);
    }

    #[Route('/migration/customer', name: 'app_migration_customer')]
    public function customer(HttpClientInterface $client): JsonResponse
    {
        $sourceConnector = new WooCustomerConnector(
            $client,
            $_ENV['WOOCOMMERCE_API_URL_CUSTOMERS'],
            $_ENV['WOOCOMMERCE_API_KEY'],
            $_ENV['WOOCOMMERCE_API_SECRET']
        );
        $destinationConnector = new MagentoCustomerConnector();
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
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/MigrationController.php',
        ]);
    }
}
