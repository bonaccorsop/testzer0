<?php

namespace Test0\Application;

use Test0\Service\Service;

class ServiceProvider
{
    private $services = [];

    /**
     * @param string $name
     * @param Service $service
     * @return ServiceProvider
     */
    public function addService(string $name, Service $service) : ServiceProvider
    {
        $this->services[$name] = $service;
        return $this;
    }

    /**
     * @param string $name
     * @return Service $service
     */
    public function getService(string $name) : Service
    {
        return ! empty($this->services[$name]) ? $this->services[$name] : null;
    }

}