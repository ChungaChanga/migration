<?php

namespace App\Event;


use Doctrine\Common\Collections\Collection;
use http\Client\Response;
use Symfony\Contracts\EventDispatcher\Event;
use Symfony\Contracts\HttpClient\ResponseInterface;

class EntitiesCreateErrorEvent extends Event
{
    public const NAME = 'entities.create.error';
    public function __construct(
        private Collection $entities,
        private array $result
    )
    {
    }

    public function getEntities(): Collection
    {
        return $this->entities;
    }

    public function getResult(): array
    {
        return $this->result;
    }
}