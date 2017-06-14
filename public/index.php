<?php

//bootloading delle dipendenze
require_once __DIR__ . '/../bootstrap.php';

// --------------------------------------------------------------------
// Init HTTP instance with injection of dependecies
// --------------------------------------------------------------------

$app = new \Silex\Application();
$app['debug'] = env('APP_DEBUG', false);

// --------------------------------------------------------------------
// Load Routes
// --------------------------------------------------------------------

require_once APP_CWD . '/app/routes.php';

// --------------------------------------------------------------------
// Run the application HTTP interface...
// --------------------------------------------------------------------

$app->run();