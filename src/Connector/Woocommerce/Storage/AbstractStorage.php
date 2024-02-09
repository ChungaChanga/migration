<?php

namespace App\Connector\Woocommerce\Storage;

use App\Iterator\AwaitingIteratorWrapper;
use App\Connector\AbstractRepositoryRead;
use App\Contract\Connector\Repository\StorageReadInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Contracts\HttpClient\HttpClientInterface;

abstract class AbstractStorage implements StorageReadInterface
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