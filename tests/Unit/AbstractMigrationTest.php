<?php

namespace App\Tests\Unit;

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

class AbstractMigrationTest extends TestBase
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
        self::bootKernel();
        $container = static::getContainer();

        $eventDispatcher = $container->get(EventDispatcherInterface::class);

        $httpClientMock = new MockHttpClient();
        $paramsMock = $this->createMock(ContainerBagInterface::class);

        $fakeSourceRepository = new CustomerRepositoryStub();
        $fakeDestRepository = new CustomerRepositoryStub();

        $connectorFactory = new ConnectorFactory(
            MigrationType::Customers,
            $httpClientMock,
            $eventDispatcher,
            $paramsMock
        );
        $this->sourceConnector = $connectorFactory->createSourceConnector();
        $this->destConnector = $connectorFactory->createDestinationConnector();

        $this->sourceConnector->setRepository($fakeSourceRepository);
        $this->destConnector->setRepository($fakeDestRepository);
    }

    /**
     * @dataProvider doubleProvider
     * @return void
     * @throws \Exception
     */
    public function testDoubleThrowError($customer1, $customer2)
    {
        $iterator = $this->sourceConnector->createIterator(
            1,
        );
        $this->sourceConnector->setIterator($iterator);
        $this->sourceConnector->getRepository()->createOne($customer1);
        $this->sourceConnector->getRepository()->createOne($customer2);

        $migration = new Migration(
            $this->sourceConnector,
            $this->destConnector,
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
        $iterator = $this->sourceConnector->createIterator(
            1,
        );
        $this->sourceConnector->setIterator($iterator);
        $this->sourceConnector->getRepository()->createOne($customer1);
        $this->sourceConnector->getRepository()->createOne($customer2);

        $migration = new Migration(
            $this->sourceConnector,
            $this->destConnector,
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
}