<?php

namespace Test0\Service;

use stdClass;

use Test0\Application\Exception\InvalidPageLengthException;
use Test0\Application\Exception\PostNotFoundException;
use Test0\Application\Exception\PostNotAllowedException;

use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints as Assert;

use Test0\Repository\PostRepository;
use Illuminate\Database\Query\Builder;

class PostService extends Service
{
    private $postRepository;

    const MAX_PAGELEN = 100;

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
     * @throws InvalidPageLengthException
     */
    public function listForUser(int $uid, int $page, int $pagelen) : array
    {
        if($pagelen > self::MAX_PAGELEN) {
            throw new InvalidPageLengthException('The specified page length is too large!', 413);
        }

        return $this->postRepository->getAll(function(Builder $query) use ($uid) {
            return $query->where('user_id', $uid)->orderBy('id', 'desc');
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
     * @throws PostNotFoundException
     * @throws PostNotAllowedException
     */
    public function findForUser(int $uid, int $postId) : stdClass
    {
        return $this->pickPostForUser($uid, $postId);
    }

    /**
     * @param int $uid
     * @param array $postData
     * @return stdClass
     * @throws InvalidPostDataException
     */
    public function createForUser(int $uid, array $postData) : stdClass
    {
        //validation @TODO
        //$this->validatePostData($postData);

        return $this->postRepository->create(array_merge($postData, ['user_id' => $uid]));
    }

    /**
     * @param int $uid
     * @param int $postId
     * @param array $postData
     * @return stdClass
     * @throws InvalidPostDataException
     */
    public function updateForUser(int $uid, int $postId, array $postData) : stdClass
    {
        $post = $this->pickPostForUser($uid, $postId);

        //validation @TODO
        //$this->validatePostData($postData);

        $this->postRepository->update($post->id, $postData);

        return $post;
    }

    /**
     * @param int $uid
     * @param int $postId
     * @return bool
     * @throws PostNotAllowedException
     * @throws PostNotFoundException
     */
    public function deleteForUser(int $uid, int $postId) : bool
    {
        $post = $this->pickPostForUser($uid, $postId);
        return $this->postRepository->delete($post->id);
    }

    /**
     * @param array $data
     * @return bool
     * @throws InvalidPostdataException
     */
    private function validatePostData(array $data)
    {
        $constraint = new Assert\Collection([
            'content' => new Assert\Length(['min' => 10]),
            'content' => new Assert\Length(['min' => 10]),
        ]);

        // $errors = Validation::createValidator()->validate($data, $constraint);

        // dd($errors);
    }

    /**
     * @param int $uid
     * @param int $postId
     * @return stdClass
     * @throws PostNotAllowedException
     * @throws PostNotFoundException
     */
    private function pickPostForUser(int $uid, int $postId)
    {
        $post = $this->postRepository->getForUser($uid, $postId);

        if(empty($post)) {
            if(! empty($this->postRepository->pick($uid))) {
                throw new PostNotAllowedException("This post in not allowed for you", 401);
            } else {
                throw new PostNotFoundException("No post found with id {$postId}", 404);
            }
        }

        return $post;
    }

}