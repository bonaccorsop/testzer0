<?php

namespace Test0\Http\Middleware;

use Exception;
use Symfony\Component\HttpFoundation\Request;
use Test0\Http\Controller\Controller;
use Test0\Service\AuthService;


class AuthMiddleware extends Controller
{
    protected $authService;

    /**
     * @param Test0\Http\Application $app
     * @param AuthService $authService
     * @return AuthMiddleware
     */
    public function __construct($app, AuthService $authService)
    {
        parent::__construct($app);
        $this->authService = $authService;

    }

    /**
     * @param Test0\Http\Application $app
     * @param AuthService $authService
     * @return null
     */
    public function run(Request $request)
    {
        $token = $request->headers->get('token');

        try {
            $uid = $this->authService->authorize($token);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }

        self::setUserID($uid);
    }

}