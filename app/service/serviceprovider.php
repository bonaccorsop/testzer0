<?php

$serviceProvider = new Test0\Application\ServiceProvider;

// --------------------------------------------------------------------
// AuthService
// --------------------------------------------------------------------

use Test0\Service\AuthService;
use Test0\Repository\UserRepository;

$serviceProvider->addService('AuthService', new AuthService($logger, new UserRepository($mysqlClient), env('JWT_HMACKEY'), env('JWT_TTL')));

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