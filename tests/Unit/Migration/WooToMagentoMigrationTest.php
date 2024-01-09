<?php declare(strict_types=1);

/**
 * Test migration from Woocommerce to Magento2
 */
namespace App\Tests\Unit\Migration;

use App\Connector\ConnectorReadType;
use App\Connector\ConnectorWriteType;
use App\Connector\Magento\Factory\CustomerConnectorFactory as MagentoFactory;
use App\Connector\Woocommerce\Factory\CustomerConnectorFactory as WooFactory;
use App\Migration\Migration;
use App\Tests\Fake\CustomerRepositoryStub;
use App\Tests\Fixtures\CustomersInterface;
use App\Tests\Fixtures\Magento\Customers as MagentoCustomers;
use App\Tests\Fixtures\Woocommerce\Customers as WoocommerceCustomers;
use App\Tests\TestBase;
use Chungachanga\AbstractMigration\EntityHandler\BaseHandler;
use Doctrine\ORM\EntityManagerInterface;

class WooToMagentoMigrationTest extends TestBase
{
    private WooFactory $sourceConnectorFactory;
    private MagentoFactory $destConnectorFactory;
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
        $this->sourceConnectorFactory = $this->getMockBuilder(WooFactory::class)
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->onlyMethods(['createRepository'])
            ->getMock();
        $this->destConnectorFactory = $this->getMockBuilder(MagentoFactory::class)
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->onlyMethods(['createRepository'])
            ->getMock();
        $this->entityManagerMock = $this->getMockBuilder(EntityManagerInterface::class)
            ->getMock();
    }

    /**
     * @dataProvider  countProvider
     */
    public function testCustomersCountNotWaitingFullPage(
        $customers, $customersCount, $startPage, $pageSize, $isAllowPartialResult
    )
    {
        $fakeSourceRepository = new CustomerRepositoryStub();
        $this->sourceConnectorFactory
            ->method('createRepository')
            ->will($this->returnValue($fakeSourceRepository));
        $fakeDestRepository = new CustomerRepositoryStub();
        $this->destConnectorFactory
            ->method('createRepository')
            ->will($this->returnValue($fakeDestRepository));

        $sourceConnector = new ConnectorReadType(
            $this->sourceConnectorFactory,
            $startPage,
            $pageSize,
            false,
            $isAllowPartialResult
        );
        $destConnector = new ConnectorWriteType($this->destConnectorFactory);

        $fakeSourceRepository->create($customers);

        $migration = new Migration(
            $sourceConnector,
            $destConnector,
            new BaseHandler()
        );

        $migration->start();
        $this->assertCount(
            $customersCount,
            $fakeDestRepository->fetchPage(1, 99999)
        );
    }

    /**
     * @dataProvider  mappingProvider
     */
    public function testCustomersDataNotWaitingFullPage(
        $woocommerceCustomers, $magentoCustomers, $startPage, $pageSize, $isAllowPartialResult
    )
    {
        $fakeSourceRepository = new CustomerRepositoryStub();
        $this->sourceConnectorFactory
            ->method('createRepository')
            ->will($this->returnValue($fakeSourceRepository));
        $fakeDestRepository = new CustomerRepositoryStub();
        $this->destConnectorFactory
            ->method('createRepository')
            ->will($this->returnValue($fakeDestRepository));

        $sourceConnector = new ConnectorReadType(
            $this->sourceConnectorFactory,
            $startPage,
            $pageSize,
            false,
            $isAllowPartialResult
        );
        $destConnector = new ConnectorWriteType($this->destConnectorFactory);

        $fakeSourceRepository->create($woocommerceCustomers);

        $migration = new Migration(
            $sourceConnector,
            $destConnector,
            new BaseHandler()
        );

        $migration->start();
        foreach ($fakeDestRepository->fetchPage(1, 99999) as $k => $customerFromWoocommerce) {
            $this->assertEquals($customerFromWoocommerce['entity']['email'], $magentoCustomers[$k]['email']);
        }
    }


    public function Tmp()
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


    public function countProvider()
    {
        return [
            [
                [],
                0,//will migrated count
                1,//pageStart
                5,//pageSize,
                true,//isAllowPartialResult
            ],
            [
                [
                    $this->fixturesWoocommerce->first(),
                ],
                1,
                1,
                10,
                true,//isAllowPartialResult
            ],
            [
                [
                    $this->fixturesWoocommerce->first(),
                    $this->fixturesWoocommerce->second(),
                    $this->fixturesWoocommerce->third(),
                    $this->fixturesWoocommerce->fourth(),
                ],
                4,
                1,
                2,
                true,//isAllowPartialResult
            ],
            [
                [
                    $this->fixturesWoocommerce->first(),
                    $this->fixturesWoocommerce->second(),
                    $this->fixturesWoocommerce->third(),
                    $this->fixturesWoocommerce->fourth(),
                    $this->fixturesWoocommerce->fifth(),
                ],
                5,
                1,
                2,
                true,//isAllowPartialResult
            ],

            [
                [
                    $this->fixturesWoocommerce->first(),
                ],
                0,
                1,
                10,
                false,//isAllowPartialResult
            ],
            [
                [
                    $this->fixturesWoocommerce->first(),
                    $this->fixturesWoocommerce->second(),
                    $this->fixturesWoocommerce->third(),
                    $this->fixturesWoocommerce->fourth(),
                ],
                4,
                1,
                2,
                false,//isAllowPartialResult
            ],
            [
                [
                    $this->fixturesWoocommerce->first(),
                    $this->fixturesWoocommerce->second(),
                    $this->fixturesWoocommerce->third(),
                    $this->fixturesWoocommerce->fourth(),
                    $this->fixturesWoocommerce->fifth(),
                ],
                4,
                1,
                2,
                false,//isAllowPartialResult
            ],
        ];
    }

    public function mappingProvider()
    {
        return [
            [
                [
                    $this->fixturesWoocommerce->first(),
                ],
                [
                    $this->fixturesMagento->first(),
                ],
                1,
                10,
                true,//isAllowPartialResult
            ],
            [
                [
                    $this->fixturesWoocommerce->first(),
                    $this->fixturesWoocommerce->second(),
                    $this->fixturesWoocommerce->third(),
                    $this->fixturesWoocommerce->fourth(),
                ],
                [
                    $this->fixturesMagento->first(),
                    $this->fixturesMagento->second(),
                    $this->fixturesMagento->third(),
                    $this->fixturesMagento->fourth(),
                ],
                1,
                2,
                true,//isAllowPartialResult
            ],
            [
                [
                    $this->fixturesWoocommerce->first(),
                    $this->fixturesWoocommerce->second(),
                    $this->fixturesWoocommerce->third(),
                    $this->fixturesWoocommerce->fourth(),
                    $this->fixturesWoocommerce->fifth(),
                ],
                [
                    $this->fixturesMagento->first(),
                    $this->fixturesMagento->second(),
                    $this->fixturesMagento->third(),
                    $this->fixturesMagento->fourth(),
                    $this->fixturesMagento->fifth(),
                ],
                1,
                2,
                true,//isAllowPartialResult
            ],
            [
                [
                    $this->fixturesWoocommerce->first(),
                    $this->fixturesWoocommerce->second(),
                    $this->fixturesWoocommerce->third(),
                    $this->fixturesWoocommerce->fourth(),
                ],
                [
                    $this->fixturesMagento->first(),
                    $this->fixturesMagento->second(),
                    $this->fixturesMagento->third(),
                    $this->fixturesMagento->fourth(),
                ],
                1,
                2,
                false,//isAllowPartialResult
            ],
            [
                [
                    $this->fixturesWoocommerce->first(),
                    $this->fixturesWoocommerce->second(),
                    $this->fixturesWoocommerce->third(),
                    $this->fixturesWoocommerce->fourth(),
                    $this->fixturesWoocommerce->fifth(),
                ],
                [
                    $this->fixturesMagento->first(),
                    $this->fixturesMagento->second(),
                    $this->fixturesMagento->third(),
                    $this->fixturesMagento->fourth(),
                    $this->fixturesMagento->fifth(),
                ],
                1,
                2,
                false,//isAllowPartialResult
            ],

        ];
    }
}