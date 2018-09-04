<?php
declare(strict_types=1);
namespace Twee\TwoCheckout;

use Zend\Http\Client as HttpClient;
use Zend\Http\Request as HttpRequest;
use Zend\Http\Header as HttpHeader;

use RuntimeException;

final class Api
{
    const ENDPOINT = 'https://api.2checkout.com/rest/5.0';

    const METHOD_GET = 'get';

    private $vendorCode = '';
    private $httpClient = null;

    public function __construct(string $vendorCode)
    {
        $this->vendorCode = $vendorCode;
        $this->httpClient =
    }

    private function generateRequestDateTime()
    {
        // YYYY-MM-DD HH:MM:SS
        return date('Y-m-d H:i:s', time());
    }

    private function generateHash(string $requestDateTime)
    {
        return md5(((string) strlen($this->vendorCode)) . $this->vendorCode . ((string) strlen($requestDateTime)) . $requestDateTime);
    }

    public function rest(string $type, string $subUri, array $params)
    {
        $requestDateTime = $this->generateRequestDateTime();
        $hash = $this->generateHash($requestDateTime);

        $authentificationCode = 'code="' . $this->vendorCode . '" date="' . $requestDateTime . '" hash="' . $hash .'"';

        $url = self::ENDPOINT . $subUri;
        if ($type == self::METHOD_GET) {
            $url = $url . '?' . http_build_query($params);
        }

        $this->httpClient->setUri(new Uri($url));
        $this->httpClient->setOptions([
            'sslverifypeer' => false,
        ]);
        $this->httpClient->setHeaders([
            new HttpHeader\GenericHeader('X-Avangate-Authentication', 'code="' . $this->vendorCode . '" date="{REQUEST_DATE_TIME}" hash="{HASH}"'),
        ]);

        $response = $this->httpClient->send();

        if (!$response->isSuccess()) {
            throw new RuntimeException('http error', $response->getStatusCode(), new RuntimeException($response->getBody()));
        }

        return json_decode($response->getBody(), true);
    }
}
