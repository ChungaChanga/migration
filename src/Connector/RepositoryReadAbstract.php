<?php declare(strict_types=1);

namespace App\Connector;

use App\Iterator\AwaitingIteratorWrapper;
use Chungachanga\AbstractMigration\Repository\RepositoryReadInterface;

abstract class RepositoryReadAbstract implements RepositoryReadInterface
{
    protected function validatePage(int $page): void
    {
        if ($page < 1) {
            throw new \InvalidArgumentException('Page must be more than 1');
        }
    }
}