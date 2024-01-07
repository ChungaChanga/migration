<?php

namespace App\Connector\Woocommerce\Repository;

use App\Iterator\AwaitingIteratorWrapper;
use App\Connector\RepositoryReadAbstract;
use Symfony\Contracts\HttpClient\HttpClientInterface;

abstract class AbstractRepository extends RepositoryReadAbstract
{
    public function __construct(
        protected HttpClientInterface $client,
        protected string $url,
        protected string $key,
        protected string $secret,
    )
    {
    }

    public function createAwaitingPageIterator(
        int $startPage,
        int $pageSize = 10,
        int $jumpSize = 0,
    ): AwaitingIteratorWrapper
    {
        if ($startPage < 1) {
            throw new \InvalidArgumentException('start page is must be more than 0 for Woocommerce api');
        }
        return parent::createAwaitingPageIterator($startPage, $pageSize, $jumpSize); // TODO: Change the autogenerated stub
    }
}