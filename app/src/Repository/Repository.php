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

}