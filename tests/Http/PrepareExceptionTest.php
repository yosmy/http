<?php

namespace Yosmy\Test\Http;

use PHPUnit\Framework\TestCase;
use Yosmy\Http;

class PrepareExceptionTest extends TestCase
{
    public function testPrepare()
    {
        $prepareException = new Http\PrepareException();

        $expected = new Http\Exception([
            'foo' => 'bar'
        ]);

        $actual = $prepareException->prepare('{"foo": "bar"}');

        $this->assertEquals(
            $expected,
            $actual
        );
    }

    public function testPrepareWithStringJsonResponse()
    {
        $prepareException = new Http\PrepareException();

        $expected = new Http\Exception(['foo']);

        $actual = $prepareException->prepare('"foo"');

        $this->assertEquals(
            $expected,
            $actual
        );
    }

    public function testPrepareWithNonJsonResponse()
    {
        $prepareException = new Http\PrepareException();

        $expected = new Http\Exception(['<p />']);

        $actual = $prepareException->prepare('<p />');

        $this->assertEquals(
            $expected,
            $actual
        );
    }
}