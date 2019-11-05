<?php

namespace Yosmy\Test\Http;

use Yosmy;
use PHPUnit\Framework\TestCase;

class ExceptionTest extends TestCase
{
    public function testJsonSerializer()
    {
        $response = [
            'code' => 'code'
        ];

        $exception = new Yosmy\Http\Exception($response);

        $this->assertEquals(
            [
                'response' => $exception->getResponse()
            ],
            $exception->jsonSerialize()
        );
    }
}