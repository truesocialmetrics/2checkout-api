<?php
namespace Twee\TwoCheckout;

use PHPUnit\Framework\TestCase;

class ApiTest extends TestCase
{
    public function test()
    {
        $api = new Api('TopSecretCode');
    }
}
