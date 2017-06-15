<?php

namespace Test0\Repository;

use Illuminate\Database\Capsule\Manager as MysqlClient;

abstract class Repository
{
    const DEFAULT_PAGELEN = 10;

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

}