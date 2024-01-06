<?php

namespace App\Connector\Memory;

use Chungachanga\AbstractMigration\Connector\FactoryFullInterface;
use Chungachanga\AbstractMigration\Mapper\MapperFullInterface;
use Chungachanga\AbstractMigration\Repository\RepositoryFullInterface;

class SimpleFactory implements FactoryFullInterface
{
    public function createRepository(): RepositoryFullInterface
    {
        // TODO: Implement createRepository() method.
    }

    public function createMapper(): MapperFullInterface
    {
        // TODO: Implement createMapper() method.
    }

    public function createReadingIterator(): \Iterator
    {
        // TODO: Implement createReadingIterator() method.
    }

    public function createWritingIterator(): \Iterator
    {
        // TODO: Implement createWritingIterator() method.
    }

}