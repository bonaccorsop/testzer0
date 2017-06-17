<?php

namespace Test0\Http\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

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
     * @route me/posts
     * @return JsonResponse
     */
    public function index(Request $request) : JsonResponse
    {
        $uid = self::getUserID();

        return $this->jsonResponse(
            $this->getCollectionBody(
                $this->postService->listForUser($uid, $this->getPage(), $this->getPageLen()),
                $this->postService->countForUser($uid)
            )
        );
    }

    /**
     * @param int $postId
     * @param Request $requests
     * @return JsonResponse
     */
    public function find(int $postId, Request $requests) : JsonResponse
    {
        try {
            return $this->jsonResponse($this->getItemBody($this->postService->findforUser(self::getUserID(), $postId)));
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request) : JsonResponse
    {
        $postData = $this->decodeRequestPayload($request->getContent());

        try {
            $post = $this->postService->createforUser(self::getUserID(), $postData);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }

        return $this->jsonResponse($this->getItemBody($post), 201);
    }

    /**
     * @param int $postId
     * @param Request $requests
     * @return JsonResponse
     */
    public function update(int $postId, Request $request) : JsonResponse
    {
        $postData = $this->decodeRequestPayload($request->getContent());

        try {
            $post = $this->postService->updateforUser(self::getUserID(), $postId, $postData);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }

        return $this->jsonResponse([], 204);
    }

    /**
     * @param int $postId
     * @param Request $requests
     * @return JsonResponse
     */
    public function delete(int $postId, Request $request) : JsonResponse
    {
        try {
            $post = $this->postService->deleteforUser(self::getUserID(), $postId);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }

        return $this->jsonResponse([], 204);
    }

}