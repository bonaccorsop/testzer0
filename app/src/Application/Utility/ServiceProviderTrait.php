<?php

namespace Test0\Application\Utility;

use Test0\Application\ServiceProvider;
use Test0\Service\Service;


trait ServiceProviderTrait
{
    private $serviceProvider;

    /**
     * @param ServiceProvider $serviceProvider
     * @return Application
     */
    public function setServiceProvider(ServiceProvider $serviceProvider)
    {
        $this->serviceProvider = $serviceProvider;
        return $this;
    }

    /**
     * @return ServiceProvider
     */
    public function getServiceProvider() : ServiceProvider
    {
        return $this->serviceProvider;
    }

    /**
     * @param string $serviceName
     * @return Service
     */
    public function getService(string $serviceName) : Service
    {
        return $this->getServiceProvider()->getService($serviceName);
    }

}