<?php

namespace Test0\Http\Controller;

use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Test0\Http\Application;
use Test0\Http\Utility\InputTrait;

abstract class Controller
{
    use InputTrait;

    const PAGE_KEY = 'page';
    const PAGELEN_KEY = 'pagelen';
    const TOTAL_KEY = 'total';
    const DATA_KEY = 'data';

    const DEFAULT_PAGELEN = 10;

    protected $app;
    protected static $userId;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * @return null
     */
    protected static function setUserID(int $id)
    {
        self::$userId = $id;
    }

    /**
     * @return int
     */
    protected static function getUserID()
    {
        return self::$userId;
    }

    /**
     * @return Application
     */
    protected function getApplication() : Application
    {
        return $this->app;
    }

    /**
     * @return string $payload
     * @return array
     */
    protected function decodeRequestPayload(string $payload) : array
    {
        return json_decode($payload, true);
    }

    /**
     * @param mixed $body
     * @param int $statusCode
     * @return JsonResponse
     */
    protected function jsonResponse($body, int $statusCode = 200) : JsonResponse
    {
        return new JsonResponse($body, $statusCode);
    }

    /**
     * @param string $message
     * @param int $statusCode
     * @return JsonResponse
     */
    protected function errorResponse(string $message, int $statusCode = 400) : JsonResponse
    {
        $statusCode = $this->resolveStatusCode($statusCode);

        $body = [
            'status' => 'error',
            'code' => $statusCode,
            'message' => $message
        ];

        return $this->jsonResponse($body, $statusCode);
    }

    /**
     * @param array $data
     * @param int $statusCode
     * @return JsonResponse
     */
    protected function successResponse(array $data, int $statusCode = 200) : JsonResponse
    {
        $body = [
            'status' => 'success',
            'code' => $statusCode,
            'data' => $data
        ];

        return $this->jsonResponse($body, $statusCode);
    }

    /**
     * @return int
     */
    protected function getPage() : int
    {
        return $this->inputGet(self::PAGE_KEY, 1);
    }

    /**
     * @return int
     */
    protected function getPageLen() : int
    {
        return $this->inputGet(self::PAGELEN_KEY, self::DEFAULT_PAGELEN);
    }

    /**
     * @param array $data
     * @param int $total
     * @return array
     */
    protected function getCollectionBody(array $data, int $total = null) : array
    {
        return [
            self::PAGE_KEY => $this->getPage(),
            self::PAGELEN_KEY => $this->getPageLen(),
            self::TOTAL_KEY => $total,
            self::DATA_KEY => $data
        ];
    }

    /**
     * @param mixed $data
     * @param int $total
     * @return array
     */
    protected function getItemBody($data) : array
    {
        return [
            self::DATA_KEY => $data
        ];
    }

    /**
     * @param callable $callback
     * @return JsonResponse
     */
    protected function trapErrorResponse(callable $callback) : JsonResponse
    {
        try {
            return $callback();
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param int $statusCode
     * @return int
     */
    private function resolveStatusCode(int $statusCode) : int
    {
        return ($statusCode > 200 && $statusCode < 600) ? $statusCode : 500;
    }

    /**
     * @return array
     */
    protected function getExcludedIds() : array
    {
        return array_filter(explode(',', $this->inputGet('exclude')), function($v){return ! empty($v);});
    }



}