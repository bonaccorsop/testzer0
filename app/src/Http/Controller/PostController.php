<?php

namespace Test0\Http\Controller;

use Test0\Service\PostService;

class PostController extends Controller
{
    protected $postService;

    /**
     * @param PostService $postService
     * @return PostController
     */
    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }


    public function index()
    {
        return $this->jsonResponse($this->postService->list());
    }

}