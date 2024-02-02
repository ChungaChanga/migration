<?php declare(strict_types=1);

/**
 * Test migration from Woocommerce to Magento2
 */
namespace App\Tests\Unit\Migration;

use App\Connector\ConnectorFactory;
use App\Migration\Migration;
use App\Migration\MigrationType;
use App\Tests\Fake\CustomerRepositoryStub;
use App\Tests\Fixtures\CustomersInterface;
use App\Tests\Fixtures\Magento\Customers as MagentoCustomers;
use App\Tests\Fixtures\Woocommerce\Customers as WoocommerceCustomers;
use App\Tests\TestBase;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpClient\MockHttpClient;

class OrdersMigrationTest extends TestBase
{
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
        $httpClientMock = new MockHttpClient();
        $eventDispatcherMock = $this->createMock(EventDispatcherInterface::class);
        $paramsMock = $this->createMock(ContainerBagInterface::class);

        $fakeSourceRepository = new CustomerRepositoryStub();
        $fakeDestRepository = new CustomerRepositoryStub();

        $connectorFactory = new ConnectorFactory(
            MigrationType::Customers,
            $httpClientMock,
            $eventDispatcherMock,
            $paramsMock
        );
        $this->sourceConnector = $connectorFactory->createSourceConnector();
        $this->destConnector = $connectorFactory->createDestinationConnector();

        $this->sourceConnector->setRepository($fakeSourceRepository);
        $this->destConnector->setRepository($fakeDestRepository);
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

        $iterator = $this->sourceConnector->createIterator(
            $startPage,
            $pageSize,
            false,
            $isAllowPartialResult
        );
        $this->sourceConnector->setIterator($iterator);

        foreach ($customers as $customer) {
            $this->sourceConnector->getRepository()->createOne($customer);
        }

        $migration = new Migration(
            $this->sourceConnector,
            $this->destConnector,
        );

        $migration->start();
        $this->assertCount(
            $customersCount,
            $this->destConnector->getRepository()->fetchPage(1, 99999)
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
        $iterator = $this->sourceConnector->createIterator(
            $startPage,
            $pageSize,
            false,
            $isAllowPartialResult
        );
        $this->sourceConnector->setIterator($iterator);

        foreach ($woocommerceCustomers as $customer) {
            $this->sourceConnector->getRepository()->createOne($customer);
        }

        $migration = new Migration(
            $this->sourceConnector,
            $this->destConnector,
        );

        $migration->start();
        foreach ($this->destConnector->getRepository()->fetchPage(1, 99999) as $k => $customerFromWoocommerce) {
            $this->assertEquals($customerFromWoocommerce['customer']['email'], $magentoCustomers[$k]['email']);
        }
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