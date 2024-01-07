<?php declare(strict_types=1);

/**
 * Test migration from Woocommerce to Magento2
 */
namespace App\Tests\Unit\Migration\Woocommerce\Magento;

use App\Connector\Memory\Connector;
use App\Connector\Memory\ConnectorElementsFactory;
use App\Migration\Migration;
use App\Migration\MigrationState;
use App\Tests\Fixtures\CustomersInterface;
use App\Tests\Fixtures\Magento\Customers as MagentoCustomers;
use App\Tests\Fixtures\Woocommerce\Customers as WoocommerceCustomers;
use App\Tests\TestBase;
use App\TransferStrategy\CustomerTransferStrategy;
use Chungachanga\AbstractMigration\Connection\Connection;
use Chungachanga\AbstractMigration\Connector\ConnectorReadInterface;
use Chungachanga\AbstractMigration\Connector\ConnectorWriteInterface;
use Chungachanga\AbstractMigration\EntityHandler\BaseHandler;
use Doctrine\ORM\EntityManagerInterface;

class CustomerTest extends TestBase
{
    private ConnectorReadInterface $sourceConnectorMock;
    private ConnectorWriteInterface $destConnectorMock;
    private EntityManagerInterface $entityManagerMock;
    private CustomersInterface $fixturesWoocommerce;
    private CustomersInterface $fixturesMagento;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        $this->fixturesWoocommerce = new WoocommerceCustomers();
        $this->fixturesMagento = new MagentoCustomers();
        parent::__construct($name, $data, $dataName);
    }

    public function setUp(): void
    {
        $entityType = 'customer';//fixme enum

        $sourceFactory = new ConnectorElementsFactory($entityType);

        $this->sourceConnector = new Connector(
            $sourceFactory->createRepository(),
            $sourceFactory->createMapper()
        );

        $destFactory = new ConnectorElementsFactory($entityType);
        $this->destConnector = new Connector(
            $sourceFactory->createRepository(),
            $sourceFactory->createMapper()
        );

        $this->entityManagerMock = $this->getMockBuilder(EntityManagerInterface::class)
            ->getMock();
    }

//    /**
//     * @dataProvider  validCountProvider
//     */
//    public function testCustomersCountNotWaiting($customers, $customersCount)
//    {
//        $isNeedWaiting = false;
//
//        $this->sourceConnectorMock->getRepository()->create($customers);
//        $connection = new Connection(
//            $this->sourceConnectorMock,
//            $this->destConnectorMock,
//        );
//
//        $strategy = new CustomerTransferStrategy($this->destConnectorMock, $this->entityManagerMock);
//
//        $migrationState = new MigrationState(
//            static::class,
//            1,
//            10,
//            $isNeedWaiting,
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
//        $connection->getDestinationConnector()->getRepository();
//        $this->assertCount(
//            $customersCount,
//            $connection->getDestinationConnector()->getRepository()->fetchPage(1, 99999)
//        );
//    }
    /**
     * @dataProvider  validCountProvider
     */
    public function testCustomersCountNotWaiting($customers, $customersCount)
    {
        $isNeedWaiting = false;

        $this->sourceConnectorMock->getWritingIterator($customers);
        $connection = new Connection(
            $this->sourceConnectorMock,
            $this->destConnectorMock,
        );

        $strategy = new CustomerTransferStrategy($this->destConnectorMock, $this->entityManagerMock);

        $migrationState = new MigrationState(
            static::class,
            1,
            10,
            $isNeedWaiting,
        );

        $migration = new Migration(
            $connection,
            $strategy,
            $migrationState,
            new BaseHandler()
        );

        $migration->start();
        $connection->getDestinationConnector()->getRepository();
        $this->assertCount(
            $customersCount,
            $connection->getDestinationConnector()->getRepository()->fetchPage(1, 99999)
        );
    }


    public function testTmp()
    {
        /**
         * Config
         * source
         * destination
         * entityType
         * pageStartNumber
         * pageSize
         * pageJump
         *
         * ConnectionFactory
         * createSourceConnectorFactory()
         * createDestConnectorFactory()
         *
         * ConnectorReadType
         * getReadingIterator()
         *
         *  ConnectorWriteType
         *  //trigger event entity.created
         *  create($entities)
         *
         * MigrationState
         * name
         * lastPage
         * pageSize
         * pageJump
         *
         * Migration
         * name
         *
         * __constructor
         *      //todo resume?
         *      name = source + destination + entityType
         *      if (fetchState)
         * getName(): string
         * fetchState(): MigrationState
         * start()
         *
         * $connectionFactory = new ConnectionFactory('woocommerce', 'magento', 'customers');
         * ReadConnectorFactory $sourceConnectorFactory = $connectionFactory->createSourceConnectorFactory();
         * WriteConnectorFactory $destConnectorFactory = $connectionFactory->createDestConnectorFactory();
         * ReadConnectorInterface $sourceConnector = new ConnectorReadType($sourceConnectorFactory)
         * WriteConnectorInterface $destConnector = new ConnectorWriteType($destConnectorFactory)
         *
         * $migration = new Migration($config);
         *
         * migration->start($state);
         *
         *
         *
         *
         *
         *
         *
         *
         *
         *
         */
    }


    public function validCountProvider()
    {
        return [
            [
                [],
                0
            ],
            [
                [
                    $this->fixturesWoocommerce->first(),
                ],
                1
            ],
            [
                [
                    $this->fixturesWoocommerce->first(),
                    $this->fixturesWoocommerce->second(),
                    $this->fixturesWoocommerce->third(),
                    $this->fixturesWoocommerce->fourth(),
                ],
                4
            ],
            [
                [
                    $this->fixturesWoocommerce->first(),
                    $this->fixturesWoocommerce->second(),
                    $this->fixturesWoocommerce->third(),
                    $this->fixturesWoocommerce->fourth(),
                    $this->fixturesWoocommerce->fifth(),
                ],
                5
            ],
        ];
    }
}