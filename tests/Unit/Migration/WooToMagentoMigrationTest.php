<?php declare(strict_types=1);

/**
 * Test migration from Woocommerce to Magento2
 */
namespace App\Tests\Unit\Migration;

use App\Connector\ConnectorReadType;
use App\Connector\ConnectorWriteType;
use App\Connector\Magento\ConnectorBuilder\CustomerConnectorBuilder as MagentoConnectorBuilder;
use App\Connector\Woocommerce\ConnectorBuilder\CustomerConnectorBuilder as WooConnectorBuilder;
use App\Migration\Migration;
use App\Tests\Fake\CustomerRepositoryStub;
use App\Tests\Fixtures\CustomersInterface;
use App\Tests\Fixtures\Magento\Customers as MagentoCustomers;
use App\Tests\Fixtures\Woocommerce\Customers as WoocommerceCustomers;
use App\Tests\TestBase;
use Chungachanga\AbstractMigration\EntityHandler\BaseHandler;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class WooToMagentoMigrationTest extends TestBase
{
    private WooConnectorBuilder $sourceConnectorBuilder;
    private MagentoConnectorBuilder $destConnectorBuilder;
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
        $this->entityManagerMock = $this->createMock(EntityManagerInterface::class);
        $httpClientMock = $this->createMock(HttpClientInterface::class);

        $fakeSourceRepository = new CustomerRepositoryStub();
        $fakeDestRepository = new CustomerRepositoryStub();
        $this->sourceConnectorBuilder = new WooConnectorBuilder();
        $this->destConnectorBuilder = new MagentoConnectorBuilder();

        $this->sourceConnectorBuilder->reset();
        $this->sourceConnectorBuilder->createMapper();
        $this->sourceConnectorBuilder->getConnector()->setRepository($fakeSourceRepository);


        $this->destConnectorBuilder->reset();
        $this->destConnectorBuilder->createMapper();
        $this->destConnectorBuilder->getConnector()->setRepository($fakeDestRepository);
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * @dataProvider  countProvider
     */
    public function testCustomersCountNotWaitingFullPage(
        array $customers,
        int $customersCount,
        int $startPage,
        int $pageSize,
        bool $isAllowPartialResult
    ): void
    {
        $this->sourceConnectorBuilder->createIterator(
            $startPage,
            $pageSize,
            false,
            $isAllowPartialResult
        );

        $sourceConnector = $this->sourceConnectorBuilder->getConnector();
        $destConnector = $this->destConnectorBuilder->getConnector();

        $sourceConnector->getRepository()->create($customers);

        $migration = new Migration(
            $sourceConnector,
            $destConnector,
        );

        $migration->start();
        $this->assertCount(
            $customersCount,
            $destConnector->getRepository()->fetchPage(1, 99999)
        );
    }



    /**
     * @dataProvider  mappingProvider
     */
    public function testCustomersDataNotWaitingFullPage(
        array $woocommerceCustomers,
        array $magentoCustomers,
        int $startPage,
        int $pageSize,
        bool $isAllowPartialResult
    ): void
    {
        $this->sourceConnectorBuilder->createIterator(
            $startPage,
            $pageSize,
            false,
            $isAllowPartialResult
        );

        $sourceConnector = $this->sourceConnectorBuilder->getConnector();
        $destConnector = $this->destConnectorBuilder->getConnector();

        $sourceConnector->getRepository()->create($woocommerceCustomers);

        $migration = new Migration(
            $sourceConnector,
            $destConnector,
        );

        $migration->start();
        foreach ($destConnector->getRepository()->fetchPage(1, 99999) as $k => $customerFromWoocommerce) {
            $this->assertEquals($customerFromWoocommerce['customer']['email'], $magentoCustomers[$k]['email']);
        }
    }

    /**
     * @dataProvider  mappingProvider
     */
    public function testEvents(
        array $woocommerceCustomers,
        array $magentoCustomers,
        int $startPage,
        int $pageSize,
        bool $isAllowPartialResult
    ): void
    {

        self::bootKernel();
        $container = static::getContainer();
        $eventDispatcher = $container->get(EventDispatcherInterface::class);
        $this->destConnectorBuilder->createEventDispatcher($eventDispatcher);

        $this->sourceConnectorBuilder->createIterator(
            $startPage,
            $pageSize,
            false,
            $isAllowPartialResult
        );

        $sourceConnector = $this->sourceConnectorBuilder->getConnector();
        $destConnector = $this->destConnectorBuilder->getConnector();

        $sourceConnector->getRepository()->create($woocommerceCustomers);

        $migration = new Migration(
            $sourceConnector,
            $destConnector,
        );

        $migration->start();
        foreach ($destConnector->getRepository()->fetchPage(1, 99999) as $k => $customerFromWoocommerce) {
            $this->assertEquals($customerFromWoocommerce['customer']['email'], $magentoCustomers[$k]['email']);
        }
    }

    /**
     * @dataProvider doubleProvider
     * @return void
     * @throws \Exception
     */
    public function testDoubleThrowError($customer1, $customer2)
    {
        self::bootKernel();
        $container = static::getContainer();
        $eventDispatcher = $container->get(EventDispatcherInterface::class);
        $this->destConnectorBuilder->createEventDispatcher($eventDispatcher);

        $this->sourceConnectorBuilder->createIterator(
            1,
        );

        $sourceConnector = $this->sourceConnectorBuilder->getConnector();
        $destConnector = $this->destConnectorBuilder->getConnector();

        $sourceConnector->getRepository()->createOne($customer1);
        $sourceConnector->getRepository()->createOne($customer2);

        $migration = new Migration(
            $sourceConnector,
            $destConnector,
        );

        $this->expectException(\Exception::class);
        $migration->start();
    }

    /**
     * @dataProvider notDoubleProvider
     * @return void
     * @throws \Exception
     */
    public function testNotDoubleNotThrowError($customer1, $customer2)
    {
        self::bootKernel();
        $container = static::getContainer();
        $eventDispatcher = $container->get(EventDispatcherInterface::class);
        $this->destConnectorBuilder->createEventDispatcher($eventDispatcher);

        $this->sourceConnectorBuilder->createIterator(
            1,
        );

        $sourceConnector = $this->sourceConnectorBuilder->getConnector();
        $destConnector = $this->destConnectorBuilder->getConnector();

        $sourceConnector->getRepository()->createOne($customer1);
        $sourceConnector->getRepository()->createOne($customer2);

        $migration = new Migration(
            $sourceConnector,
            $destConnector
        );

        $this->expectNotToPerformAssertions();
        $migration->start();
    }

    public function doubleProvider()
    {
        return [
            'double set 1' => [
                $this->fixturesWoocommerce->first(),
                $this->fixturesWoocommerce->first(),
            ],
            'double set 2' => [
                $this->fixturesWoocommerce->second(),
                $this->fixturesWoocommerce->second(),
            ],
        ];
    }

    public function notDoubleProvider(): array
    {
        return [
            'valid set 1' => [
                $this->fixturesWoocommerce->first(),
                $this->fixturesWoocommerce->second(),
            ],
            'valid set 2' => [
                $this->fixturesWoocommerce->first(),
                $this->fixturesWoocommerce->fourth(),
            ],
        ];
    }
    public function countProvider(): array
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

    public function mappingProvider(): array
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