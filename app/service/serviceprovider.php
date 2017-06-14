<?php

$serviceProvider = new Test0\Application\ServiceProvider;

// --------------------------------------------------------------------
// PostService
// --------------------------------------------------------------------

use Test0\Service\PostService;
use Test0\Repository\PostRepository;

$serviceProvider->addService('PostService', new PostService($logger, new PostRepository($mysqlClient)));


// --------------------------------------------------------------------
// End and return
// --------------------------------------------------------------------

return $serviceProvider;