<?php

// --------------------------------------------------------------------
// Application dependencies bootstrap
// --------------------------------------------------------------------

require_once __DIR__ . '/../bootstrap.php';

// --------------------------------------------------------------------
// Load Service Provider
// --------------------------------------------------------------------

$serviceProvider = require APP_CWD . '/app/service/serviceprovider.php';

// --------------------------------------------------------------------
// Init HTTP instance with injection of dependecies
// --------------------------------------------------------------------

$app = new Test0\Http\Application;
$app['debug'] = env('APP_DEBUG', false);

$app->setServiceProvider($serviceProvider);

// --------------------------------------------------------------------
// Load Routes
// --------------------------------------------------------------------

require_once APP_CWD . '/app/http/routes.php';

// --------------------------------------------------------------------
// Run the application HTTP interface...
// --------------------------------------------------------------------

$app->run();