<?php

namespace App\Tests\Fake;

use Doctrine\ORM\EntityManager;

class EntityManagerMock extends EntityManager
{
    public function persist($entity)
    {
    }

    public function flush($entity = null)
    {
    }
}