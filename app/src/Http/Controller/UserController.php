<?php

namespace Test0\Http\Controller;

use Exception;
use Test0\Service\AuthService;
use Test0\Application\Exception\PostNotFoundException;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class UserController extends Controller
{
    protected $authService;

    /**
     * @param Test0\Http\Application $app
     * @param AuthService $authService
     * @return PostController
     */
    public function __construct($app, AuthService $authService)
    {
        parent::__construct($app);
        $this->authService = $authService;
    }

    /**
     * @return Symfony\Component\HttpFoundation\JsonResponse
     */
    public function test()
    {
        return $this->successResponse([
            'message' => 'Holà!',
            'userId' => self::getUserID(),
        ], 200);
    }



}