<?php
/**
 * https://developer.adobe.com/commerce/webapi/rest/quick-reference/
 */
namespace App\Connector\Magento\Repository;

use App\Contract\Connector\Repository\RepositoryWriteInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

abstract class AbstractRepository implements RepositoryWriteInterface
{
    public function __construct(
        protected HttpClientInterface $client,
        protected string $url,
    )
    {
    }
}