<?php

declare(strict_types=1);

namespace App\Command;

//require '../../vendor/autoload.php';


use App\Connector\ConnectorFactory;
use App\Connector\ConnectorWriteType;
use App\Connector\Memory\Mapper\CustomerMapper;
use App\Connector\Memory\Storage\StorageStub;
use App\Migration\Migration;
use App\Migration\MigrationType;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

// название команды - это то, что пользователь вводит после "bin/console"
#[AsCommand(name: 'migration:start')]
class StartCommand extends Command
{
    public function __construct(
        private HttpClientInterface $client,
        private EntityManagerInterface $entityManager,
        private ContainerBagInterface $params,
        private LoggerInterface $logger,
    )
    {
        parent::__construct();
    }
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $connectorFactory = new ConnectorFactory(
            MigrationType::Customers,
            $this->client,
            $this->entityManager,
            $this->params
        );

        $sourceConnector = $connectorFactory->createSourceConnector();
        $sourceConnector->setIterator($sourceConnector->createIterator(
            startPage: 1,
            pageSize: 2,
            delaySeconds: 2,
            jumpSize: 2
        ));

        $destConnector = new ConnectorWriteType(
            new StorageStub(),
            $this->entityManager,
            new CustomerMapper()
        );

        $migration = new Migration(
            $sourceConnector,
            $destConnector,
            $this->logger
        );

        $migration->start();

        return Command::SUCCESS;
    }
}