<?php declare(strict_types=1);

/**
 * Test migration from Woocommerce to Magento2
 */
namespace App\Tests\Unit\Migration\Woocommerce\Magento;

use App\Connector\Magento\Connector\CustomerConnector as MagentoCustomerConnector;
use App\Connector\Memory\Repository\CustomerRepository;
use App\Connector\Woocommerce\Connector\CustomerConnector as WooCustomerConnector;
use App\Migration\Migration;
use App\Migration\MigrationState;
use App\Tests\Fixtures\CustomersInterface;
use App\Tests\Fixtures\Magento\Customers as MagentoCustomers;
use App\Tests\Fixtures\Woocommerce\Customers as WoocommerceCustomers;
use App\Tests\TestBase;
use App\TransferStrategy\CustomerTransferStrategy;
use Chungachanga\AbstractMigration\Connection\Connection;
use Chungachanga\AbstractMigration\Connector\ConnectorReaderInterface;
use Chungachanga\AbstractMigration\Connector\ConnectorWriterInterface;
use Chungachanga\AbstractMigration\EntityHandler\BaseHandler;
use Doctrine\ORM\EntityManagerInterface;

class CustomerTest extends TestBase
{
    private ConnectorReaderInterface $sourceConnectorMock;
    private ConnectorWriterInterface $destConnectorMock;
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
        $sourceRepository = new CustomerRepository();
        $this->sourceConnectorMock = $this->getMockBuilder(WooCustomerConnector::class)
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->onlyMethods(['getRepository'])
            ->getMock();
        $this->sourceConnectorMock->method('getRepository')
            ->will($this->returnValue($sourceRepository));

        $destRepository = new CustomerRepository();
        $this->destConnectorMock = $this->getMockBuilder(MagentoCustomerConnector::class)
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->onlyMethods(['getRepository'])
            ->getMock();
        $this->destConnectorMock->method('getRepository')
            ->will($this->returnValue($destRepository));

        $this->entityManagerMock = $this->getMockBuilder(EntityManagerInterface::class)
            ->getMock();
    }

    /**
     * @dataProvider  validCountProvider
     */
    public function testCustomersCountNotWaiting($customers, $customersCount)
    {
        $isNeedWaiting = false;

        $this->sourceConnectorMock->getRepository()->create($customers);
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