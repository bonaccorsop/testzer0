<?php

namespace Test0\Http\Controller;

use Test0\Service\PostService;

class PostController extends Controller
{
    protected $postService;

    /**
     * @param Test0\Http\Application $app
     * @param PostService $postService
     * @return PostController
     */
    public function __construct($app, PostService $postService)
    {
        parent::__construct($app);
        $this->postService = $postService;
    }

    /**
     * @return Symfony\Component\HttpFoundation\JsonResponse
     */
    public function index()
    {
        return $this->jsonResponse($this->postService->list());
    }

}