<?php

namespace Test0\Service;

use Test0\Repository\PostRepository;
use Test0\Application\Exception\PostNotFoundException;
use Illuminate\Database\Query\Builder;
use stdClass;

class PostService extends Service
{
    private $postRepository;

    /**
     * @param Logger $logger
     * @param PostRepository $postRepository
     * @return PostService
     */
    public function __construct($logger, PostRepository $postRepository)
    {
        parent::__construct($logger);
        $this->postRepository = $postRepository;
    }

    /**
     * @param int $uid
     * @param int $page
     * @param int $pagelen
     * @return array
     */
    public function listForUser(int $uid, int $page, int $pagelen) : array
    {
        return $this->postRepository->getAll(function(Builder $query) use ($uid) {
            return $query->where('user_id', $uid);
        }, $page, $pagelen);
    }

    /**
     * @param int $uid
     * @return int
     */
    public function countForUser(int $uid) : int
    {
        return $this->postRepository->getCount(function(Builder $query) use ($uid) {
            return $query->where('user_id', $uid);
        });
    }

    /**
     * @param int $uid
     * @return stdClass
     */
    public function findForUser(int $uid, int $postId) : stdClass
    {
        $post = $this->postRepository->getFirst([
            'id' => $postId,
            'user_id' => $uid
        ]);

        if(empty($post)) {
            throw new PostNotFoundException("No post found with id {$postId}", 404);
        }

        return $post;
    }

}