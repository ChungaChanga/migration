<?php

namespace App\Entity;

use App\EntityTransferStatus;
use Doctrine\ORM\Mapping as ORM;

#[ORM\MappedSuperclass]
abstract class AbstractEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected ?int $id = null;

    #[ORM\Column]
    protected ?int $sourceId = null;

    #[ORM\Column(type: 'string', enumType: EntityTransferStatus::class)]
    protected EntityTransferStatus $transferStatus;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $destId = null;

    #[ORM\Column(length: 65000, nullable: true)]
    private ?string $transferData = null;

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