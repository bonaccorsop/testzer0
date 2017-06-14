<?php

namespace Test0\Application\Utility;

use Psr\Log\LoggerInterface;

trait LogTrait
{
    private $logger = null;

    /**
     * @param LoggerInterface $logger
     */
    protected function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param MysqlClient $mysqlClient
     * @return LoggerInterface
     */
    protected function getLogger()
    {
        return $this->logger;
    }


    /**
     * @param string $text
     * @param array $context
     */
    public function logInfo(string $text, $context = null)
    {
        $this->logger->logInfo($text, $context);
    }

}