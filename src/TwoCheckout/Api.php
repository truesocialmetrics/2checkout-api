<?php
namespace Twee\TwoCheckout;

final class Api
{
    const ENDPOINT = 'https://api.2checkout.com/rest/5.0';

    private $vendorCode = '';

    public function __construct(string $vendorCode)
    {
        $this->vendorCode = $vendorCode;
    }

    private function generateHash(string $requestDateTime)
    {

    }

    private function rest(string $type, string $uri, array $params)
    {

    }
}
