<?php

namespace Test0\Service;

use Illuminate\Database\Capsule\Manager as MysqlClient;
use Monolog\Logger;

abstract class Service
{
    private $mysqlClient = null;
    private $logger = null;

    /**
     * @param MysqlClient $mysqlClient
     * @param Logger $logger
     * @return Service
     */
    public function __construct(MysqlClient $mysqlClient, Logger $logger)
    {
        $this->setMysqlClient($mysqlClient)
            ->setLogger($logger);
    }

    /**
     * @param MysqlClient $mysqlClient
     * @return Service
     */
    protected function setMysqlClient(MysqlClient $mysqlClient)
    {
        $this->mysqlClient = $mysqlClient;
        return $this;
    }

    /**
     * @param MysqlClient $mysqlClient
     * @return Service
     */
    protected function setLogger(Logger $logger)
    {
        $this->logger = $logger;
        return $this;
    }

}