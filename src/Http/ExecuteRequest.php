<?php

namespace Yosmy\Http;

use GuzzleHttp;

/**
 * @di\service({
 *     deductible: false
 * })
 */
class ExecuteRequest
{
    const METHOD_GET = 'get';
    const METHOD_POST = 'post';

    /**
     * @var PrepareException
     */
    private $prepareException;

    /**
     * @var GuzzleHttp\ClientInterface
     */
    private $client;

    /**
     * @di\arguments({
     *     prepareException: "@yosmy.http.prepare_exception"
     * })
     *
     * @param PrepareException                $prepareException
     * @param GuzzleHttp\ClientInterface|null $client
     */
    public function __construct(
        PrepareException $prepareException,
        GuzzleHttp\ClientInterface $client = null
    ) {
        $this->prepareException = $prepareException;
        $this->client = $client ?? new GuzzleHttp\Client();
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array  $options
     *
     * @return Response
     *
     * @throws Exception
     */
    public function execute(
        string $method,
        string $uri,
        array $options
    ): Response {
        try {
            $response = $this->client->request(
                $method,
                $uri,
                $options
            );
        } catch (GuzzleHttp\Exception\ClientException $e) {
            $response = (string) $e->getResponse()->getBody();

            $e = $this->prepareException->prepare($response);

            throw $e;
        } catch (GuzzleHttp\Exception\GuzzleException $e) {
            $response = (string) $e->getMessage();

            $e = $this->prepareException->prepare($response);

            throw $e;
        }

        return new Response($response);
    }
}
