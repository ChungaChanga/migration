<?php

namespace App\Entity;

use App\EntityTransferStatus;
use Doctrine\ORM\Mapping as ORM;

#[ORM\MappedSuperclass]
abstract class EntityAbstract
{
    #[ORM\Column(type: 'string', enumType: EntityTransferStatus::class)]
    protected EntityTransferStatus $transferStatus;

    protected function getTransferStatus(): EntityTransferStatus
    {
        return $this->transferStatus;
    }

    protected function setTransferStatus(EntityTransferStatus $transferStatus)
    {
        $this->transferStatus = $transferStatus;

        return $this;
    }
}