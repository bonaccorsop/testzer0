<?php

namespace Test0\Service;

use Test0\Application\Utility\LogTrait;

abstract class Service
{
    use LogTrait;

    /**
     * @param Logger $logger
     * @return Service
     */
    public function __construct($logger)
    {
        $this->setLogger($logger);
    }

}