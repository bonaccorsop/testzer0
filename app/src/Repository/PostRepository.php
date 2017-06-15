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

    /**
     * @param callable $filterCallback (optional)
     * @return stdClass
     */
    public function pick(int $id)
    {
        return $this->getTable()->find($id);
    }

    /**
     * @param callable $filterCallback (optional)
     * @return int
     */
    public function getCount(callable $filterCallback = null) : int
    {
        return $this->getFiltered($filterCallback)->count();
    }

    /**
     * @param array $params (optional)
     * @return array
     */
    public function getAll(callable $filterCallback = null, int $page, int $pagelen) : array
    {
        return $this->paginate($this->getFiltered($filterCallback), $pagelen, $page)->get()->toArray();
    }

}