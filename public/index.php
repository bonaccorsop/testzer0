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
$app->register(new Silex\Provider\ServiceControllerServiceProvider());

// --------------------------------------------------------------------
// Load Routes
// --------------------------------------------------------------------

require_once APP_CWD . '/app/http/routes.php';

// --------------------------------------------------------------------
// CORS allow *
// --------------------------------------------------------------------

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE');
header("Access-Control-Allow-Headers: X-Requested-With");

// --------------------------------------------------------------------
// Run the application HTTP interface...
// --------------------------------------------------------------------

$app->run();