<?php

namespace Yosmy\Http;

use Psr\Http\Message\ResponseInterface;

class Response
{
    /**
     * @var ResponseInterface
     */
    private $response;

    /**
     * @param ResponseInterface $response
     */
    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->response->getStatusCode();
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->response->getHeaders();
    }

    /**
     * @return string
     */
    public function getRawBody(): string
    {
        return (string) $this->response->getBody();
    }

    /**
     * @return array
     */
    public function getBody(): array
    {
        return json_decode($this->getRawBody(), true);
    }
}
