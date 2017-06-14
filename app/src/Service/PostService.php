<?php

namespace Test0\Service;

use Test0\Repository\PostRepository;

final class PostService extends Service
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
     * @param array $params (optional)
     * @return array
     */
    public function list(array $params = null) : array
    {
        return $this->postRepository->getAll($params);
    }

}