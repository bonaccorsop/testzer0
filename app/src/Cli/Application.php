<?php

namespace Test0\Cli;

use Symfony\Component\Console\Application as SynfonyConsoleApp;
use Test0\Application\Utility\ServiceProviderTrait;


final class Application extends SynfonyConsoleApp
{
    use ServiceProviderTrait;
}