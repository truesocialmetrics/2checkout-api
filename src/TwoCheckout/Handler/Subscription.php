<?php
declare(strict_types=1);
namespace Twee\TwoCheckout\Handler;

final class Subscription extends Abstracthandler
{
    public function retrieve(array $params)
    {
        return $this->getApiClient()->rest(self::METHOD_GET, '/subscriptions/', $params);
    }
}
