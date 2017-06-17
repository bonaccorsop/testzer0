<?php

namespace Test0\Repository;

use stdClass;
use Illuminate\Database\Query\Builder;

class PostRepository extends Repository implements RepositoryInterface
{
    /**
     * @return Illuminate\Database\Query\Builder
     */
    public function getTable() : Builder
    {
        return $this->getMysqlClient()->table('posts');
    }

    /**
     * @param int $uid
     * @param int $postId
     * @return stdClass
     */
    public function getForUser(int $uid, int $postId)
    {
        return $this->getFirst([
            'id' => $postId,
            'user_id' => $uid
        ]);
    }

}