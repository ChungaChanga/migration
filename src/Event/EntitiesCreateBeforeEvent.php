<?php

namespace App\Event;


use Doctrine\Common\Collections\Collection;
use http\Client\Response;
use Symfony\Contracts\EventDispatcher\Event;
use Symfony\Contracts\HttpClient\ResponseInterface;

class EntitiesCreateBeforeEvent extends Event
{
    public const NAME = 'entities.create.before';
    public function __construct(
        private Collection $entities,
    )
    {
    }

    public function getEntities(): Collection
    {
        return $this->entities;
    }
}