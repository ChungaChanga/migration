<?php

namespace App\Tests\Functional;

use App\Connector\Magento\ConnectorBuilder\CustomerConnectorBuilder as MagentoConnectorBuilder;
use App\Connector\Woocommerce\ConnectorBuilder\CustomerConnectorBuilder as WooConnectorBuilder;
use App\Tests\Fake\CustomerRepositoryStub;
use App\Tests\Fixtures\CustomersInterface;
use App\Tests\Fixtures\Magento\Customers as MagentoCustomers;
use App\Tests\Fixtures\Woocommerce\Customers as WoocommerceCustomers;
use App\Tests\TestBase;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Config\ConfigCache;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class Migration extends TestBase
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
}

