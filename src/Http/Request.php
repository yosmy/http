<?php

namespace Yosmy\Http;

class Request
{
    /**
     * @var string
     */
    private $method;

    /**
     * @var string
     */
    private $uri;

    /**
     * @var array
     */
    private $options;

    /**
     * @param string $method
     * @param string $uri
     * @param array $options
     */
    public function __construct(
        string $method,
        string $uri,
        array $options
    ) {
        $this->method = $method;
        $this->uri = $uri;
        $this->options = $options;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }
}
