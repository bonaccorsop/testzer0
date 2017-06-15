<?php

namespace Test0\Http\Controller;

use Exception;
use Test0\Service\AuthService;
use Test0\Application\Exception\PostNotFoundException;


class UserController extends Controller
{
    protected $authService;

    const USERNAME_KEY = 'username';
    const PASSWORD_KEY = 'password';

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
    public function login()
    {
        $credentials = $this->inputRaw();

        try {
            $token = $this->authService->authenticate($credentials[self::USERNAME_KEY], base64_decode($credentials[self::PASSWORD_KEY]));
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }

        return $this->successResponse([
            'message' => 'You\'re logged in!',
            'token' => (string) $token
        ], 201);
    }

    /**
     * @return Symfony\Component\HttpFoundation\JsonResponse
     */
    public function logout()
    {
        $this->authService->voidToken(self::getUserID());
        return $this->successResponse([], 204);
    }


    public function test()
    {
        return $this->successResponse([
            'message' => 'Holà!',
            'userId' => self::getUserID(),
        ], 200);
    }





}