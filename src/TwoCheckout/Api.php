<?php
declare(strict_types=1);
namespace Twee\TwoCheckout;

use Zend\Http\Client as HttpClient;
use Zend\Http\Request as HttpRequest;
use Zend\Http\Header as HttpHeader;

use RuntimeException;
use UnderflowException;

final class Api
{
    const ENDPOINT = 'https://api.2checkout.com/rest/5.0';

    const METHOD_GET = 'get';

    private $vendorCode = '';
    private $secretCode = '';

    private $httpClient = null;

    public function __construct(string $vendorCode, string $secretCode)
    {
        $this->vendorCode = $vendorCode;
        $this->secretCode = $secretCode;

        $this->httpClient = new HttpClient();
    }

    public function rest(string $type, string $subUri, array $params) : array
    {
        $code = $this->vendorCode;
        $key  = $this->secretCode;
        $date = gmdate('Y-m-d H:i:s', time());
        $hash = hash_hmac('md5', strlen($code) . $code . strlen($date) . $date, $key);

        $url = self::ENDPOINT . $subUri;
        if ($type == self::METHOD_GET) {
            $url = $url . '?' . http_build_query($params);
        }

        $this->httpClient->setUri($url);
        $this->httpClient->setOptions([
            'sslverifypeer' => false,
        ]);
        $this->httpClient->setHeaders([
            new HttpHeader\GenericHeader('X-Avangate-Authentication', 'code="' . $code . '" date="' . $date . '" hash="' . $hash . '"'),
            new HttpHeader\Accept('application/json'),
            new HttpHeader\ContentType('application/json'),
        ]);

        $response = $this->httpClient->send();

        if (!$response->isSuccess()) {
            throw new RuntimeException('http error', $response->getStatusCode(), new RuntimeException($response->getBody()));
        }

        $decoded = json_decode($response->getBody(), true);
        if ($decoded === false) {
            throw new UnderflowException('Response cant be decoded');
        }

        return $decoded;
    }
}
