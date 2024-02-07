<?php

namespace App\Tests\Functional;

use App\Connector\ConnectorFactory;
use App\Migration\Migration;
use App\Migration\MigrationType;
use App\Tests\Fake\Connector\RepositoryStub;
use App\Tests\Fixtures\CustomersInterface;
use App\Tests\Fixtures\Woocommerce\Customers as WoocommerceCustomers;
use App\Tests\TestBase;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpClient\MockHttpClient;

class AbstractMigrationTest extends TestBase
{
    private CustomersInterface $fixturesWoocommerce;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        $this->fixturesWoocommerce = new WoocommerceCustomers();
        parent::__construct($name, $data, $dataName);
    }

    public function setUp(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        $entityManager = $container->get(EntityManagerInterface::class);

        $httpClientMock = new MockHttpClient();
        $paramsMock = $this->createMock(ContainerBagInterface::class);

        $fakeSourceRepository = new RepositoryStub();
        $fakeDestRepository = new RepositoryStub();

        $connectorFactory = new ConnectorFactory(
            MigrationType::Customers,
            $httpClientMock,
            $entityManager,
            $paramsMock
        );
        $this->sourceConnector = $connectorFactory->createSourceConnector();
        $this->destConnector = $connectorFactory->createDestinationConnector();

        $this->sourceConnector->setRepository($fakeSourceRepository);
        $this->destConnector->setRepository($fakeDestRepository);
    }

    /**
     * @dataProvider customersProvider
     * @return void
     * @throws \Exception
     */
    public function testDoubleThrowError($customer)
    {
        $iterator = $this->sourceConnector->createIterator(
            1,
        );
        $this->sourceConnector->setIterator($iterator);
        $this->sourceConnector->getRepository()->createOne($customer);
        $this->sourceConnector->getRepository()->createOne($customer);

        $migration = new Migration(
            $this->sourceConnector,
            $this->destConnector,
        );

        $this->expectException(\Exception::class);
        $migration->start();
    }

    /**
     * @dataProvider customersProvider
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

    public function customersProvider(): array
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