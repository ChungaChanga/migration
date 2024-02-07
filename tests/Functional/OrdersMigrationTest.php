<?php declare(strict_types=1);

/**
 * Test migration from Woocommerce to Magento2
 */
namespace App\Tests\Functional;

use App\Connector\ConnectorFactory;
use App\Migration\Migration;
use App\Migration\MigrationType;
use App\Tests\Fake\Connector\RepositoryStub;
use App\Tests\Fixtures\Magento\Orders as MagentoOrders;
use App\Tests\Fixtures\OrdersInterface;
use App\Tests\Fixtures\Woocommerce\Orders as WoocommerceOrders;
use App\Tests\TestBase;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\HttpClient\MockHttpClient;

class OrdersMigrationTest extends TestBase
{
    private OrdersInterface $woocommerceOrders;
    private OrdersInterface $magentoOrders;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        $this->woocommerceOrders = new WoocommerceOrders();
        $this->magentoOrders = new MagentoOrders();
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
            MigrationType::Orders,
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
     * @dataProvider  countProvider
     */
    public function testEntityCountNotWaitingNewEntities(
        array $entities,
        int $entitiesCount,
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

        foreach ($entities as $entity) {
            $this->sourceConnector->getRepository()->createOne($entity);
        }

        $migration = new Migration(
            $this->sourceConnector,
            $this->destConnector,
        );

        $migration->start();
        $this->assertCount(
            $entitiesCount,
            $this->destConnector->getRepository()->fetchPage(1, 99999)
        );
    }



    /**
     * @dataProvider  mappingProvider
     */
    public function testEntitiesDataNotWaitingFullPage(
        array $woocommerceEntities,
        array $magentoEntities,
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

        foreach ($woocommerceEntities as $entity) {
            $this->sourceConnector->getRepository()->createOne($entity);
        }

        $migration = new Migration(
            $this->sourceConnector,
            $this->destConnector,
        );

        $migration->start();
        foreach ($this->destConnector->getRepository()->fetchPage(1, 99999) as $k => $entityFromWoocommerce) {
            $this->assertEquals($entityFromWoocommerce['base_grand_total'], $magentoEntities[$k]['base_grand_total']);
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
                    $this->woocommerceOrders->first(),
                ],
                1,
                1,
                10,
                true,//isAllowPartialResult
            ],
            [
                [
                    $this->woocommerceOrders->first(),
                    $this->woocommerceOrders->second(),
                    $this->woocommerceOrders->third(),
                ],
                3,
                1,
                2,
                true,//isAllowPartialResult
            ],
            [
                [
                    $this->woocommerceOrders->first(),
                ],
                0,
                1,
                10,
                false,//isAllowPartialResult
            ],
            [
                [
                    $this->woocommerceOrders->first(),
                    $this->woocommerceOrders->second(),
                ],
                2,
                1,
                2,
                false,//isAllowPartialResult
            ],
            [
                [
                    $this->woocommerceOrders->first(),
                    $this->woocommerceOrders->second(),
                    $this->woocommerceOrders->third(),
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
                    $this->woocommerceOrders->first(),
                ],
                [
                    $this->magentoOrders->first(),
                ],
                1,
                10,
                true,//isAllowPartialResult
            ],
            [
                [
                    $this->woocommerceOrders->first(),
                    $this->woocommerceOrders->second(),
                ],
                [
                    $this->magentoOrders->first(),
                    $this->magentoOrders->second(),
                ],
                1,
                2,
                true,//isAllowPartialResult
            ],
            [
                [
                    $this->woocommerceOrders->first(),
                    $this->woocommerceOrders->second(),
                    $this->woocommerceOrders->third(),
                ],
                [
                    $this->magentoOrders->first(),
                    $this->magentoOrders->second(),
                    $this->magentoOrders->third(),
                ],
                1,
                2,
                true,//isAllowPartialResult
            ],
            [
                [
                    $this->woocommerceOrders->first(),
                    $this->woocommerceOrders->second(),
                ],
                [
                    $this->magentoOrders->first(),
                    $this->magentoOrders->second(),
                ],
                1,
                2,
                false,//isAllowPartialResult
            ],
        ];
    }
}