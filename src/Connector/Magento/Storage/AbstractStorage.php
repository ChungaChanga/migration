<?php

namespace App\Connector\Magento\Storage;

use App\Contract\Connector\Repository\StorageWriteInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

abstract class AbstractStorage implements StorageWriteInterface
{
    public function __construct(
        protected HttpClientInterface $client,
        protected string $url,
    )
    {
    }
}