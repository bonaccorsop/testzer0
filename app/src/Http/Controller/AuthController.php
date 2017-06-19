<?php

namespace Test0\Http\Controller;

use Exception;
use Symfony\Component\HttpFoundation\Request;
use Test0\Http\Controller\Controller;
use Test0\Service\AuthService;


class AuthController extends Controller
{
    protected $authService;

    const USERNAME_KEY = 'username';
    const PASSWORD_KEY = 'password';

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
     * @return Symfony\Component\HttpFoundation\JsonResponse
     */
    public function login(Request $request)
    {
        return $this->trapErrorResponse(function() use ($request) {
            $credentials = $this->decodeRequestPayload($request->getContent());
            $token = $this->authService->authenticate($credentials[self::USERNAME_KEY], base64_decode($credentials[self::PASSWORD_KEY]));
            return $this->successResponse([
                'message' => 'You\'re logged in!',
                'token' => $token
            ], 201);
        });
    }

    /**
     * @return Symfony\Component\HttpFoundation\JsonResponse
     */
    public function signup(Request $request)
    {
        return $this->trapErrorResponse(function() use ($request) {
            $credentials = $this->decodeRequestPayload($request->getContent());
            $user = $this->authService->register($credentials[self::USERNAME_KEY], base64_decode($credentials[self::PASSWORD_KEY]));
            return $this->jsonResponse($this->getItemBody(['id' => $user->id, 'email' => $user->email]));
        });
    }

    /**
     * @return Symfony\Component\HttpFoundation\JsonResponse
     */
    public function userInfo(Request $request)
    {
        return $this->trapErrorResponse(function() {
            $user = $this->authService->getUserInfo(self::getUserID());
            return $this->jsonResponse($this->getItemBody(['id' => $user->id, 'email' => $user->email]));
        });


    }

    /**
     * @param Test0\Http\Application $app
     * @param AuthService $authService
     * @return null
     */
    public function middleware(Request $request)
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