<?php

namespace Test0\Http\Utility;

/**
 * @package Test0\Http\Utility
 * @author Pietro Bonaccorso
 **/
trait InputTrait
{
    /**
     * @param (string) $key (optional)
     * @param (mixed) $default (optional)
     * @return mixed
     */
    protected function inputGet($key = null, $default = null)
    {
        return $this->resolveInput($_GET, $key) ?? $default;
    }

    /**
     * @param (string) $key (optional)
     * @param (mixed) $default (optional)
     * @return mixed
     */
    protected function inputPost($key = null, $default = null)
    {
        return $this->resolveInput($_POST, $key) ?? $default;
    }

    /**
     * @param (string) $key (optional)
     * @param (mixed) $default (optional)
     * @return mixed
     */
    protected function inputCookie($key = null, $default = null, $xssClean = true)
    {
        return $this->resolveInput($_COOKIE, $key) ?? $default;
    }

    /**
     * @param array $source
     * @param (string) $key (optional)
     * @return mixed
     */
    private function resolveInput(array $source, $key = null)
    {
        return ! empty($key) ? ($source[$key] ?? null) : $source;
    }

    /**
     * Retrieves the cookie input
     *
     * @param (string) $key (optional)
     * @param (mixed) $default (optional)
     * @param (string) $decode (optional)
     * @return mixed
     */
    protected function inputRaw($key = null, $default = null, $decode = null)
    {
        $rawBody = $this->getRawBody();

        $output = json_decode($rawBody, true) ?? null;

        if(! empty($key)) {
            $output = $output[$key] ?? null;

            if(empty($output) && ! empty($default)) {
                $output = $default;
            }
        }

        return $output;
    }

    private function getRawBody()
    {
        if(empty($this->rawBody)) {
            $this->rawBody = @file_get_contents('php://input');
        }

        return $this->rawBody;
    }

}