<?php

namespace Yosmy\Test\Http;

use Yosmy\Http;
use PHPUnit\Framework\TestCase;
use GuzzleHttp;
use Psr\Http\Message\ResponseInterface;
use LogicException;

class ExecuteRequestTest extends TestCase
{
    public function testExecute()
    {
        $method = 'method';
        $uri = 'uri';
        $options = [
            'key-1' => 'value-1'
        ];
        $response = $this->createMock(ResponseInterface::class);

        $client = $this->createMock(GuzzleHttp\ClientInterface::class);

        $client->expects($this->once())
            ->method('request')
            ->with(
                $this->equalTo($method),
                $this->equalTo($uri),
                $this->equalTo($options)
            )
            ->willReturn($response);

        $prepareException = $this->createMock(Http\PrepareException::class);

        $executeRequest = new Http\ExecuteRequest(
            $prepareException,
            $client
        );

        try {
            $actual = $executeRequest->execute(
                $method,
                $uri,
                $options
            );
        } catch (Http\Exception $e) {
            throw new LogicException();
        }

        $this->assertEquals(
            new Http\Response($response),
            $actual
        );
    }

    /**
     * @throws Http\Exception
     */
    public function testExecuteThrowingClientException()
    {
        $data = 'data';

        $response = $this->createMock(ResponseInterface::class);

        $response->expects($this->once())
            ->method('getBody')
            ->willReturn($data);

        $exception = $this->createMock(GuzzleHttp\Exception\ClientException::class);

        $exception->expects($this->once())
            ->method('getResponse')
            ->willReturn($response);

        $client = $this->createMock(GuzzleHttp\ClientInterface::class);

        $client->expects($this->once())
            ->method('request')
            ->willThrowException($exception);

        $preparedException = $this->createMock(Http\Exception::class);

        $prepareException = $this->createMock(Http\PrepareException::class);

        $prepareException->expects($this->once())
            ->method('prepare')
            ->with($data)
            ->willReturn($preparedException);

        $executeRequest = new Http\ExecuteRequest(
            $prepareException,
            $client
        );

        $this->expectExceptionObject($preparedException);

        $executeRequest->execute(
            'method',
            'uri',
            []
        );
    }

    /**
     * @throws Http\Exception
     */
    public function testExecuteThrowingGuzzleException()
    {
        $data = 'data';

        $exception = new GuzzleHttp\Exception\TransferException($data);

        $client = $this->createMock(GuzzleHttp\ClientInterface::class);

        $client->expects($this->once())
            ->method('request')
            ->willThrowException($exception);

        $preparedException = $this->createMock(Http\Exception::class);

        $prepareException = $this->createMock(Http\PrepareException::class);

        $prepareException->expects($this->once())
            ->method('prepare')
            ->with($data)
            ->willReturn($preparedException);

        $executeRequest = new Http\ExecuteRequest(
            $prepareException,
            $client
        );

        $this->expectExceptionObject($preparedException);

        $executeRequest->execute(
            'method',
            'uri',
            []
        );
    }

    public function testConstants()
    {
        $this->assertEquals(
            'get',
            Http\ExecuteRequest::METHOD_GET
        );

        $this->assertEquals(
            'post',
            Http\ExecuteRequest::METHOD_POST
        );
    }
}