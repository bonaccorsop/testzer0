<?php

namespace Test0\Http\Controller;

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
    const MAX_PAGELEN = 100;

    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * @return Application
     */
    protected function getApplication() : Application
    {
        return $this->app;
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
     * @param array $message
     * @param int $statusCode
     * @return JsonResponse
     */
    protected function errorResponse(string $message, int $statusCode = 400) : JsonResponse
    {
        $body = [
            'status' => 'error',
            'code' => $statusCode,
            'message' => $message
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
        $pagelen = $this->inputGet(self::PAGELEN_KEY, self::DEFAULT_PAGELEN);
        return ($pagelen <= self::MAX_PAGELEN) ? $pagelen : self::MAX_PAGELEN;
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



}