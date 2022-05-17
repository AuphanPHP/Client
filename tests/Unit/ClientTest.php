<?php

namespace AuphanPHP\Tests\Unit;

use AidanCasey\MockClient\Client as MockClient;
use AuphanPHP\Client;
use AuphanPHP\Tests\Unit\Reports\MockReport;
use Exception;
use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\Psr7\HttpFactory;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use RuntimeException;

class ClientTest extends TestCase
{
    public function test_it_discovers_psr_implementations()
    {
        $client = new Client;

        $this->assertInstanceOf(ClientInterface::class, $client->getHttpClient());
        $this->assertInstanceOf(RequestFactoryInterface::class, $client->getRequestFactory());
    }

    public function test_it_uses_passed_psr_implementations()
    {
        $httpClient = new Guzzle;
        $requestFactory = new HttpFactory;
        $client = new Client($httpClient, $requestFactory);

        $this->assertSame($httpClient, $client->getHttpClient());
        $this->assertSame($requestFactory, $client->getRequestFactory());
    }

    public function test_it_requires_base_uri()
    {
        $this->expectExceptionObject(
            new Exception('No base uri was set. Did you forget to call setBaseUri()?')
        );

        (new Client)->getBaseUri();
    }

    public function test_it_requires_api_key()
    {
        $this->expectExceptionObject(
            new Exception('No api key was set. Did you forget to call setApiKey()')
        );

        (new Client)->getApiToken();
    }

    public function test_it_sets_base_uri()
    {
        $client = (new Client)->setBaseUri('https://w5.auphansoftware.com:18081/test/');

        $this->assertSame('https://w5.auphansoftware.com:18081/test', $client->getBaseUri());
    }

    public function test_it_sets_api_key()
    {
        $client = (new Client)->setApiToken('ABC123');

        $this->assertSame('ABC123', $client->getApiToken());
    }

    public function test_it_sets_language_id()
    {
        $client = (new Client)->setLanguageId(2);

        $this->assertSame(2, $client->getLanguageId());
    }

    public function test_getting_report()
    {
        $mock = MockClient::fake([
            'https://w2.auphansoftware.com/*' => MockClient::response(__DIR__ .'/stubs/mock.json'),
        ]);
        $client = new Client($mock);
        $client
            ->setApiToken('ABC123XYZ')
            ->setBaseUri('https://w2.auphansoftware.com/');

        $client->report(new MockReport);

        $mock
            ->assertMethod('GET')
            ->assertUri('https://w2.auphansoftware.com/reports/api.php?lang_id=1&data=%7b%22test-key%22%3a%22test-value%22%2c%22api_token%22%3a%22ABC123XYZ%22%7d');
    }

    public function test_it_throws_exception_when_json_is_not_returned()
    {
        $this->expectExceptionObject(
            new RuntimeException('api_token required')
        );

        $mock = MockClient::fake([
            'https://w2.auphansoftware.com/*' => MockClient::response('api_token required'),
        ]);

        $client = new Client($mock);
        $client
            ->setApiToken('ABC123XYZ')
            ->setBaseUri('https://w2.auphansoftware.com/');

        $client->report(new MockReport);
    }
}