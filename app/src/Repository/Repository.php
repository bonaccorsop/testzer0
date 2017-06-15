<?php

namespace Test0\Repository;

use Illuminate\Database\Capsule\Manager as MysqlClient;
use Illuminate\Database\Query\Builder;

abstract class Repository
{
    private $mysqlClient = null;

    /**
     * @param MysqlClient $mysqlClient
     * @return Repository
     */
    public function __construct(MysqlClient $mysqlClient)
    {
        $this->setMysqlClient($mysqlClient);
    }

    /**
     * @param MysqlClient $mysqlClient
     * @return Service
     */
    protected function setMysqlClient(MysqlClient $mysqlClient) : Repository
    {
        $this->mysqlClient = $mysqlClient;
        return $this;
    }

    /**
     * @return MysqlClient
     */
    protected function getMysqlClient() : MysqlClient
    {
        return $this->mysqlClient;
    }

    /**
     * @param int $pagelen (default const DEFAULT_PAGELEN)
     * @param int $page (default 1)
     * @return Builder
     */
    protected function paginate(Builder $query, int $pagelen, int $page) : Builder
    {
        return $query->forPage($page, $pagelen);
    }

    /**
     * @param callable $filterCallback
     * @return Builder
     */
    protected function getFiltered(callable $filterCallback = null) : Builder
    {
        $query = $this->getTable();
        return ! empty($filterCallback) ? $filterCallback($query) : $query;
    }

    /**
     * @param array $filter
     * @return stdClass
     */
    protected function getFirst(array $filter)
    {
        return $this->getFiltered(function(Builder $query) use ($filter) {
            return $query->where($filter);
        })->first();
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

    /**
     * @param int $id,
     * @param array $data,
     * @return stdClass
     */
    public function update(int $id, array $data)
    {
        return $this->getTable()->where(['id' => $id])->update($data);
    }

}