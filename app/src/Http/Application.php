<?php

namespace Test0\Http;

use Silex\Application as SilexApplication;
use Test0\Application\Utility\ServiceProviderTrait;


final class Application extends SilexApplication
{
    use ServiceProviderTrait;
}