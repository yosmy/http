<?php

namespace Yosmy\Http;

/**
 * @di\service()
 */
class PrepareException
{
    /**
     * @param string $response
     *
     * @return Exception
     */
    public function prepare(string $response): Exception
    {
        $jsonResponse = json_decode($response, true);

        $error = json_last_error();

        if ($error != JSON_ERROR_NONE) {
            return new Exception([$response]);
        }

        if (!is_array($jsonResponse)) {
            $jsonResponse = [$jsonResponse];
        }

        return new Exception($jsonResponse);
    }
}
