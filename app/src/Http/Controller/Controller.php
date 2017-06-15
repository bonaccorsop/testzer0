<?php

namespace Test0\Http\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Test0\Http\Application;
use Test0\Http\Utility\InputTrait;

abstract class Controller
{
    use InputTrait;

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
     * @param array $body
     * @param int $statusCode
     * @return JsonResponse
     */
    protected function jsonResponse(array $body, int $statusCode = 200) : JsonResponse
    {
        return new JsonResponse($body, $statusCode);
    }


}