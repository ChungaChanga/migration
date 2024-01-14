<?php

namespace App\Migration;

use App\Connector\ConnectorReadType;
use App\Connector\ConnectorWriteType;
use Chungachanga\AbstractMigration\EntityHandler\HandlerInterface;
use Chungachanga\AbstractMigration\Migration\MigrationInterface;
use Doctrine\Common\Collections\ArrayCollection;

class Migration implements MigrationInterface
{
    public function __construct(
        private ConnectorReadType $sourceConnector,
        private ConnectorWriteType $destConnector,
    )
    {
    }
    public function start(): void
    {
        /**
         * @var ArrayCollection $entities
         */
        foreach ($this->sourceConnector->getIterator() as $pageNum => $entities) {
            if ($entities->isEmpty()) {
                continue;
            }
            $this->destConnector->create($entities);
        }
    }
}