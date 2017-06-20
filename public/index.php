<?php

// --------------------------------------------------------------------
// CORS allow *
// --------------------------------------------------------------------

if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    // cache for 1 day
}

// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        header("Access-Control-Allow-Methods: GET, POST, PATCH, DELETE, PUT, OPTIONS");

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    exit(0);
}

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
// Run the application HTTP interface...
// --------------------------------------------------------------------

$app->run();