<?php

namespace Test0\Http\Controller;

use Exception;
use Test0\Service\PostService;
use Test0\Application\Exception\PostNotFoundException;


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
        return $this->jsonResponse(
            $this->getCollectionBody(
                $this->postService->list($this->getPage(), $this->getPageLen()),
                $this->postService->count()
            )
        );
    }

    /**
     * @return Symfony\Component\HttpFoundation\JsonResponse
     */
    public function find($postId)
    {
        try {
            return $this->jsonResponse($this->getItemBody($this->postService->find($postId)));
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @return Symfony\Component\HttpFoundation\JsonResponse
     */
    public function create()
    {

    }

    /**
     * @return Symfony\Component\HttpFoundation\JsonResponse
     */
    public function update()
    {

    }

    /**
     * @return Symfony\Component\HttpFoundation\JsonResponse
     */
    public function delete()
    {

    }

}