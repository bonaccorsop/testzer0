<?php

namespace Test0\Repository;

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

}