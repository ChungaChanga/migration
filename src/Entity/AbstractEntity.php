<?php

namespace App\Entity;

use App\EntityTransferStatus;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\MappedSuperclass]
#[UniqueEntity(
    'sourceId',
    message: 'This sourceId is already handled',
)]
#[UniqueEntity(
    'destId',
    message: 'This destId is already handled',
)]
abstract class AbstractEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected ?int $id = null;

    #[ORM\Column(unique: true)]
    protected ?int $sourceId = null;

    #[ORM\Column(type: 'string', enumType: EntityTransferStatus::class)]
    protected EntityTransferStatus $transferStatus;

    #[ORM\Column(length: 255,  unique: true, nullable: true)]
    protected ?string $destId = null;

    #[ORM\Column(length: 65000, nullable: true)]
    protected ?string $transferData = null;

    public function getTransferStatus(): EntityTransferStatus
    {
        return $this->transferStatus;
    }

    public function setTransferStatus(EntityTransferStatus $transferStatus)
    {
        $this->transferStatus = $transferStatus;

        return $this;
    }

    public function getDestId(): ?string
    {
        return $this->destId;
    }

    public function setDestId(string $destId): static
    {
        $this->destId = $destId;

        return $this;
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSourceId(): ?int
    {
        return $this->sourceId;
    }

    public function setSourceId(int $sourceId): static
    {
        $this->sourceId = $sourceId;

        return $this;
    }

    public function getTransferData(): ?string
    {
        return $this->transferData;
    }

    public function setTransferData(?string $transferData): static
    {
        $this->transferData = $transferData;

        return $this;
    }
}