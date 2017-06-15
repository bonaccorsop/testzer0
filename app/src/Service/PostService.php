<?php

namespace Test0\Service;

use Test0\Repository\PostRepository;
use Test0\Application\Exception\PostNotFoundException;
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
     * @param int $id
     * @return stdClass
     * @throws PostNotFoundException
     */
    public function find($id) : stdClass
    {
        $post = $this->postRepository->pick($id);

        if(empty($post)) {
            throw new PostNotFoundException("No post found with id {$id}", 404);
        }

        return $post;
    }

    /**
     * @param int $page
     * @param int $pagelen
     * @return array
     */
    public function list(int $page, int $pagelen) : array
    {
        return $this->postRepository->getAll(null, $page, $pagelen);
    }

    /**
     * @param int $page
     * @param int $pagelen
     * @return array
     */
    public function create(int $page, int $pagelen) : array
    {
        return $this->postRepository->store();
    }

    /**
     * @param int $page
     * @param int $pagelen
     * @return array
     */
    public function count() : int
    {
        return $this->postRepository->getCount();
    }

}