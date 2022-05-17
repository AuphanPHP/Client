<?php

namespace AuphanPHP;

use AuphanPHP\Reports\ReportInterface;
use Exception;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\Psr18ClientDiscovery;
use Illuminate\Support\Collection;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use RuntimeException;

final class Client
{
    private string $baseUri;

    private string $apiToken;

    private int $languageId = 1;

    private readonly ClientInterface $httpClient;

    private readonly RequestFactoryInterface $requestFactory;

    public function __construct(
        ?ClientInterface $httpClient = null,
        ?RequestFactoryInterface $requestFactory = null
    ) {
        $this->httpClient = $httpClient ?: Psr18ClientDiscovery::find();
        $this->requestFactory = $requestFactory ?: Psr17FactoryDiscovery::findRequestFactory();
    }

    public function getHttpClient(): ClientInterface
    {
        return $this->httpClient;
    }

    public function getRequestFactory(): RequestFactoryInterface
    {
        return $this->requestFactory;
    }

    public function getBaseUri(): string
    {
        return $this->baseUri ?? throw new Exception(
            'No base uri was set. Did you forget to call setBaseUri()?'
        );
    }

    public function setBaseUri(string $baseUri): self
    {
        $this->baseUri = rtrim($baseUri, '/');

        return $this;
    }

    public function getApiToken(): string
    {
        return $this->apiToken ?? throw new Exception(
            'No api key was set. Did you forget to call setApiKey()?'
        );
    }

    public function setApiToken(string $apiToken): self
    {
        $this->apiToken = $apiToken;

        return $this;
    }

    public function getLanguageId(): int
    {
        return $this->languageId;
    }

    public function setLanguageId(int $languageId): self
    {
        $this->languageId = $languageId;

        return $this;
    }

    public function report(ReportInterface $report): Collection
    {
        $endpoint = trim($report->getReportEndpoint(), '/');
        $parameters = $report->getReportParameters();
        $parameters['api_token'] = $this->getApiToken();
        $queryParameters = [
            'lang_id' => $this->getLanguageId(),
            'data' => json_encode($parameters),
        ];

        $query = http_build_query(data: $queryParameters, encoding_type: PHP_QUERY_RFC3986);

        $uri = $this->getBaseUri().'/'.$endpoint.'?'.$query;

        $request = $this->getRequestFactory()->createRequest('GET', $uri);
        $response = $this->getHttpClient()->sendRequest($request);
        $body = $response->getBody()->getContents();

        /** @var null|array $array */
        $array = json_decode($body, true);

        if (is_null($array)) {
            throw new RuntimeException($body);
        }

        return new Collection($array);
    }
}