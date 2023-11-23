<?php

namespace App\TransferStrategy;

use Chungachanga\AbstractMigration\Connector\ConnectorWriterInterface;
use Chungachanga\AbstractMigration\Migration\TransferStrategyInterface;
use Doctrine\ORM\EntityManagerInterface;

abstract class AbstractTransferStrategy implements TransferStrategyInterface
{
    public function __construct(
        private ConnectorWriterInterface $destinationConnector,
        private EntityManagerInterface $entityManager,
    )
    {
    }

}