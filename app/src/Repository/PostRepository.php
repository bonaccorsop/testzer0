<?php

namespace Test0\Repository;

class PostRepository extends Repository
{
    /**
     * @return Illuminate\Database\Query\Builder
     */
    private function getTable()
    {
        return $this->getMysqlClient()->table('posts');
    }

    /**
     * @param callable $filterCallback (optional)
     * @return int
     */
    public function getCount(callable $filterCallback = null) : int
    {
        return null;
    }

    /**
     * @param array $params (optional)
     * @return array
     */
    public function getAll(callable $filterCallback = null, int $page = 1, int $pagelen = self::DEFAULT_PAGELEN) : array
    {
        return $this->getTable()->get()->toArray();
        // return [
        //     ['id' => 1, 'content' => 'Lorem ipsum', 'emotion' => 'happy'],
        //     ['id' => 2, 'content' => 'docet imsam', 'emotion' => 'sad'],
        //     ['id' => 3, 'content' => 'cotti nerto', 'emotion' => 'angry'],
        // ];
    }

}