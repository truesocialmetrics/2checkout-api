<?php
namespace Twee\TwoCheckout;

use PHPUnit\Framework\TestCase;
use ReflectionMethod;

class ApiTest extends TestCase
{
    public function t_estGenerateRequestDateTime()
    {
        $api = new Api('TopSecretCode');

        $method = new ReflectionMethod(Api::class, 'generateRequestDateTime');
        $method->setAccessible(true);

        $this->assertEquals(date('Y-m-d H:i:s', time()), $method->invoke($api));
    }

    public function t_estGenerateHash()
    {
        $api = new Api('TopSecretCode');

        $method = new ReflectionMethod(Api::class, 'generateHash');
        $method->setAccessible(true);

        $this->assertEquals(md5('13TopSecretCode4abcd'), $method->invoke($api, 'abcd'));
    }
}
