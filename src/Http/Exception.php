<?php

namespace Yosmy\Http;

use Exception as BaseException;
use JsonSerializable;

class Exception extends BaseException implements JsonSerializable
{
    /**
     * @var array
     */
    private $response;

    /**
     * @param array $response
     */
    public function __construct(array $response)
    {
        $this->response = $response;

        parent::__construct();
    }

    /**
     * @return array
     */
    public function getResponse(): array
    {
        return $this->response;
    }

    /**
     * {@inheritDoc}
     */
    public function jsonSerialize(): array
    {
        return [
            'response' => $this->getResponse()
        ];
    }
}
