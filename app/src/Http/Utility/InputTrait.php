<?php

namespace Test0\Http\Utility;

/**
 * @package Test0\Http\Utility
 * @author Pietro Bonaccorso
 **/
trait InputTrait
{
    /**
     * Determines if has the specified get field
     *
     * @param (string) $key (optional)
     * @return bool
     */
    protected function hasInputGet($key = null)
    {
        $input = $this->inputGet($key);
        return ! empty($input);
    }

    // --------------------------------------------------------------------

    /**
     * Determines if has the specified post field
     *
     * @param (string) $key (optional)
     * @return bool
     */
    protected function hasInputPost($key = null)
    {
        $input = $this->inputPost($key);
        return ! empty($input);
    }

    // --------------------------------------------------------------------

    /**
     * Determines if has the specified cookie field
     *
     * @param (string) $key (optional)
     * @return bool
     */
    protected function hasInputCookie( $key = null )
    {
        $input = $this->inputCookie($key);
        return ! empty($input);
    }

    // --------------------------------------------------------------------

    /**
     * Determines if has the specified rawData field
     *
     * @param (string) $key (optional)
     * @return bool
     */
    protected function hasInputRaw($key = null)
    {
        $input = $this->inputRaw($key);
        return ! empty($input);
    }

    // --------------------------------------------------------------------

    /**
     * Determines if has the specified file
     *
     * @param (string) $key (optional)
     * @return bool
     */
    protected function hasInputFile($key = null)
    {
        $input = $this->inputFile($key);
        return ! empty($input);
    }

    // --------------------------------------------------------------------

    /**
     * Determines if has the specified input field
     *
     * @param (string) $key (optional)
     * @return bool
     */
    protected function hasInput($key)
    {
        $input = array_merge(
            $this->inputGet($key),
            $this->inputPost($key),
            $this->inputCookie($key),
            $this->inputRaw($key),
            $this->inputFile($key)
        );

        return ! empty($input);
    }

    // --------------------------------------------------------------------

    /**
     * Retrieves the get input
     *
     * @param (string) $key (optional)
     * @param (mixed) $default (optional)
     * @return mixed
     */
    protected function inputGet($key = null, $default = null)
    {
        $input = $this->resolveInput($_GET, $key);
        return $input ? $input : $default;
    }

    // --------------------------------------------------------------------

    /**
     * Retrieves the post input
     *
     * @param (string) $key (optional)
     * @param (mixed) $default (optional)
     * @param (bool) $xssClean (default true)
     * @return mixed
     */
    protected function inputPost($key = null, $default = null)
    {
        $input = $this->resolveInput($_POST, $key);
        return $input ? $input : $default;
    }

    // --------------------------------------------------------------------

    /**
     * Retrieves the cookie input
     *
     * @param (string) $key (optional)
     * @param (mixed) $default (optional)
     * @param (bool) $xssClean (default true)
     * @return mixed
     */
    protected function inputCookie($key = null, $default = null, $xssClean = true)
    {
        $input = $this->resolveInput($_COOKIE, $key, $xssClean );
        return $input ? $input : $default;
    }

    // --------------------------------------------------------------------

    private function resolveInput(array $data, $key = null)
    {
        return ! empty($key) ? ($data[$key] ?? null) : $data;
    }

    // --------------------------------------------------------------------

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

    // --------------------------------------------------------------------

    private function getRawBody()
    {
        if(empty($this->rawBody)) {
            $this->rawBody = @file_get_contents('php://input');
        }

        return $this->rawBody;
    }

    // --------------------------------------------------------------------

    /**
     * Retrieves the file input
     *
     * @param (string) $key (optional)
     * @return mixed
     */
    protected function inputFile($key = null)
    {
        $files = array_map(function($file) {

            $fileInfo = pathinfo($file['name']);
            $extension = $fileInfo['extension'];
            $uniqueName = uniqid() . '_' . $file['name'];

            $realFilename = $file['name'];

            return array_merge($file, [
                'name' => $uniqueName,
                'additionalInfo' => [
                    'realName' => $realFilename,
                    'extension' => $extension,
                ]
            ]);
        }, $_FILES);

        return ! empty($key) ? ($files[$key] ?? null) : $files;
    }

    // --------------------------------------------------------------------

    /**
     * Retrieves all client inputs
     *
     * @param (string) $key (optional)
     * @param (mixed) $default (optional)
     * @param (bool) $xssClean (default true)
     * @return mixed
     */
    protected function inputAll($key = null, $default = null)
    {
        $input = array_merge(
            $this->inputGet(null, null),
            $this->inputPost(null, null),
            $this->inputCookie( null, null ),
            $this->inputRaw(null, null),
            $this->inputFile(null)
        );

        if($key) {
            $input = $input[$key] ?? null;
        }

        return $input ? $input : $default;
    }

}