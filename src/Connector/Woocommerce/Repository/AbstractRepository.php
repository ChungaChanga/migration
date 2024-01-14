<?php

namespace App\Connector\Woocommerce\Repository;

use App\Iterator\AwaitingIteratorWrapper;
use App\Connector\AbstractRepositoryRead;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Contracts\HttpClient\HttpClientInterface;

abstract class AbstractRepository
{
    public function __construct(
        protected HttpClientInterface $client,
        protected string $url,
        protected string $key,
        protected string $secret,
    )
    {
    }
}