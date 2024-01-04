<?php
declare(strict_types=1);
namespace App\Tests\Unit\Connector\Woocommerce;

use App\Connector\Magento\Connector\CustomerConnector as MagentoCustomerConnector;
use App\Connector\Memory\Repository\CustomerRepository;
use App\Connector\Woocommerce\Connector\CustomerConnector as WooCustomerConnector;
use App\Migration\Migration;
use App\Migration\MigrationState;
use App\Tests\Fixtures\CustomersInterface;
use App\Tests\TestBase;
use App\TransferStrategy\CustomerTransferStrategy;
use Chungachanga\AbstractMigration\Connection\Connection;
use Chungachanga\AbstractMigration\Connector\ConnectorReaderInterface;
use Chungachanga\AbstractMigration\Connector\ConnectorWriterInterface;
use Chungachanga\AbstractMigration\EntityHandler\BaseHandler;
use Doctrine\ORM\EntityManagerInterface;

class CustomerMigrationTest extends TestBase
{
    private ConnectorReaderInterface $sourceConnectorMock;
    private ConnectorWriterInterface $destConnectorMock;
    private EntityManagerInterface $entityManager;
    private CustomersInterface $customers;
    public function setUp(): void
    {
        $sourceRepository = new CustomerRepository();
        $this->sourceConnectorMock = $this->getMockBuilder(WooCustomerConnector::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getRepository'])
            ->getMock();
        $this->sourceConnectorMock->method('getRepository')
            ->willReturn($sourceRepository);

        $destRepository = new CustomerRepository();
        $this->destConnectorMock = $this->getMockBuilder(MagentoCustomerConnector::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getRepository'])
            ->getMock();
        $this->destConnectorMock->method('getRepository')
            ->willReturn($destRepository);

        $this->entityManager = $this->getMockBuilder(EntityManagerInterface::class)
            ->getMock();
    }

    public function testMigration()
    {
        $this->sourceConnectorMock->getRepository()->create(self::getWoocommerceCustomersState());
        $connection = new Connection(
            $this->sourceConnectorMock,
            $this->destConnectorMock,
        );

        $strategy = new CustomerTransferStrategy($this->destConnectorMock, $this->entityManager);

        $migrationState = new MigrationState(
            static::class,
            1,
            1,
            1,
        );

        $migration = new Migration(
            $connection,
            $strategy,
            $migrationState,
            new BaseHandler()
        );

        $migration->start();

        $this->assertCount();
//        $connection->getDestinationConnector()->getRepository()
    }

    /**
     * @dataProvider validThreeProvider
     */
    public function testPause($wooData, $magentoData)
    {
        $this->sourceConnectorMock->getRepository()->create($wooData);
        $connection = new Connection(
            $this->sourceConnectorMock,
            $this->destConnectorMock,
        );

        $strategy = new CustomerTransferStrategy($this->destConnectorMock, $this->entityManager);

        $migrationState = new MigrationState(
            static::class,
            1,
            1,
            1,
        );

        $migration = new Migration(
            $connection,
            $strategy,
            $migrationState,
            new BaseHandler()
        );

        $migration->start();


    }


    public function validThreeProvider()
    {
        return [
            'woocommerce' => [
                'ordinary' => [
                    'id' => 1,
                    'email' => 'ritav@test.ru',
                    'first_name' => 'Rita',
                    'last_name' => 'Vrataski'
                ],
                'length 50 chars' => [
                    'id' => 2,
                    'email'      => 'john11111111111111111111111111111111111111@test.ru',
                    'first_name' => 'John1111111111111111111111111111111111111111111111',
                    'last_name'  => 'Wick1111111111111111111111111111111111111111111111'
                ],
                'big id' => [
                    'id' => 137789723,
                    'email' => 'johnv@test.ru',
                    'first_name' => 'John',
                    'last_name' => 'Wick'
                ],
            ],
            'magento' => [
                'ordinary' => [
                    'email' => 'ritav@test.ru',
                    'firstname' => 'Rita',
                    'lastname' => 'Vrataski'
                ],
                'length 50 chars' => [
                    'email'      => 'john11111111111111111111111111111111111111@test.ru',
                    'firstname' => 'John1111111111111111111111111111111111111111111111',
                    'lastname'  => 'Wick1111111111111111111111111111111111111111111111'
                ],
                'big id' => [
                    'email' => 'johnv@test.ru',
                    'first_name' => 'John',
                    'last_name' => 'Wick'
                ],
            ],
        ];
    }
}