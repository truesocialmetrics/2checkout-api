<?php
declare(strict_types=1);
namespace Twee\TwoCheckout\Handler;
use Twee\TwoCheckout\Api as ApiClient;

abstract class AbstractHandler
{
    const METHOD_GET = ApiClient::METHOD_GET;

    private $apiClient = null;

    public function __construct(ApiClient $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    protected function getApiClient()
    {
        return $this->apiClient;
    }
}
