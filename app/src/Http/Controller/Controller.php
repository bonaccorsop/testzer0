<?php

namespace Test0\Http\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Test0\Http\Utility\InputTrait;

abstract class Controller
{
    use InputTrait;

    protected function jsonResponse($content, $statusCode = 200)
    {
        return new JsonResponse($content, $statusCode);
    }


}