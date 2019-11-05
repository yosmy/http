<?php

namespace Yosmy\Test\Http;

use Psr\Http\Message\ResponseInterface;
use Yosmy\Http;
use PHPUnit\Framework\TestCase;

class ResponseTest extends TestCase
{
    public function testGetters()
    {
        $statusCode = 'status-code';
        $headers = [
            'key1' => 'value1',
            'key2' => 'value2',
        ];
        $body = [
            'code' => 'code',
            'result' => 'result'
        ];
        $rawBody = json_encode($body);

        $httpResponse = $this->createMock(ResponseInterface::class);

        $httpResponse->expects($this->once())
            ->method('getStatusCode')
            ->with()
            ->willReturn($statusCode);

        $httpResponse->expects($this->once())
            ->method('getHeaders')
            ->with()
            ->willReturn($headers);

        $httpResponse->expects($this->exactly(2))
            ->method('getBody')
            ->with()
            ->willReturn($rawBody);

        $response = new Http\Response($httpResponse);

        $this->assertEquals(
            $statusCode,
            $response->getStatus()
        );

        $this->assertEquals(
            $headers,
            $response->getHeaders()
        );

        $this->assertEquals(
            $rawBody,
            $response->getRawBody()
        );

        $this->assertEquals(
            $body,
            $response->getBody()
        );
    }
}