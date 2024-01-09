<?php

namespace App\Event;


use Doctrine\Common\Collections\Collection;
use http\Client\Response;
use Symfony\Contracts\EventDispatcher\Event;
use Symfony\Contracts\HttpClient\ResponseInterface;

class EntitiesCreateAfterEvent extends Event
{
    public const NAME = 'entities.create.after';
    public function __construct(
        private Collection $entities,
        private array $result
    )
    {
    }

    public function getEntities()
    {
        return $this->entities;
    }

    public function getResult()
    {
        return $this->result;
    }
}