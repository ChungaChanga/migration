<?php declare(strict_types=1);

/**
 * Test migration from Woocommerce to Magento2
 */
namespace App\Tests\Unit\Migration;

use App\Connector\ConnectorFactory;
use App\Migration\Migration;
use App\Migration\MigrationType;
use App\Tests\Fake\Connector\StorageStub;
use App\Tests\Fixtures\CustomersInterface;
use App\Tests\Fixtures\Magento\Customers as MagentoCustomers;
use App\Tests\Fixtures\Woocommerce\Customers as WoocommerceCustomers;
use App\Tests\TestBase;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpClient\MockHttpClient;

class CustomersMigrationTest extends TestBase
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
        $entityManagerMock = $this->createMock(EntityManagerInterface::class);
        $paramsMock = $this->createMock(ContainerBagInterface::class);

        $fakeSourceRepository = new StorageStub();
        $fakeDestRepository = new StorageStub();

        $connectorFactory = new ConnectorFactory(
            MigrationType::Customers,
            $httpClientMock,
            $entityManagerMock,
            $paramsMock
        );
        $this->sourceConnector = $connectorFactory->createSourceConnector();
        $this->destConnector = $connectorFactory->createDestinationConnector();

        $this->sourceConnector->setStorage($fakeSourceRepository);
        $this->destConnector->setStorage($fakeDestRepository);
    }

    /**
     * @dataProvider  countProvider
     */
    public function testCustomersCountNotWaitingNewCustomers(
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
            $this->sourceConnector->getStorage()->createOne($customer);
        }

        $migration = new Migration(
            $this->sourceConnector,
            $this->destConnector,
        );

        $migration->start();
        $this->assertCount(
            $customersCount,
            $this->destConnector->getStorage()->fetchPage(1, 99999)
        );
    }



    /**
     * @dataProvider  mappingProvider
     */
    public function testCustomersDataNotWaitingNewCustomers(
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
            $this->sourceConnector->getStorage()->createOne($customer);
        }

        $migration = new Migration(
            $this->sourceConnector,
            $this->destConnector,
        );

        $migration->start();
        foreach ($this->destConnector->getStorage()->fetchPage(1, 99999) as $k => $customerFromWoocommerce) {
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
                ],
                3,
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
                ],
                2,
                1,
                2,
                false,//isAllowPartialResult
            ],
            [
                [
                    $this->fixturesWoocommerce->first(),
                    $this->fixturesWoocommerce->second(),
                    $this->fixturesWoocommerce->third(),
                ],
                2,
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
                ],
                [
                    $this->fixturesMagento->first(),
                    $this->fixturesMagento->second(),
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
                ],
                [
                    $this->fixturesMagento->first(),
                    $this->fixturesMagento->second(),
                    $this->fixturesMagento->third(),
                ],
                1,
                2,
                true,//isAllowPartialResult
            ],
            [
                [
                    $this->fixturesWoocommerce->first(),
                    $this->fixturesWoocommerce->second(),
                ],
                [
                    $this->fixturesMagento->first(),
                    $this->fixturesMagento->second(),
                ],
                1,
                2,
                false,//isAllowPartialResult
            ],
        ];
    }
}