<?php

// --------------------------------------------------------------------
// Set CWD Constant, i love it!
// --------------------------------------------------------------------

define('APP_CWD', __DIR__);

// --------------------------------------------------------------------
// Load composer autoloader :)
// --------------------------------------------------------------------

require_once APP_CWD . '/vendor/autoload.php';

// --------------------------------------------------------------------
// Load App Constants
// --------------------------------------------------------------------

require_once APP_CWD . '/app/config/constants.php';

// --------------------------------------------------------------------
// Load unix environment variables...
// --------------------------------------------------------------------

Env::init();

// --------------------------------------------------------------------
// Set Timezone
// --------------------------------------------------------------------

date_default_timezone_set(env('APP_TIMEZONE'));

// --------------------------------------------------------------------
// Setup global Dumper, just in development scenario
// --------------------------------------------------------------------

if(env('APP_ENV') === 'development') {

    Symfony\Component\VarDumper\VarDumper::setHandler(function ($var) {
        $cloner = new Symfony\Component\VarDumper\Cloner\VarCloner();
        $dumper = 'cli' === PHP_SAPI ? new Symfony\Component\VarDumper\Dumper\CliDumper() : new Symfony\Component\VarDumper\Dumper\HtmlDumper();
        $dumper->dump($cloner->cloneVar($var));
    });

}

// --------------------------------------------------------------------
// Setup Logger
// --------------------------------------------------------------------

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$logger = new Logger(env('APP_NAME'));
$logger->pushHandler(new StreamHandler(env('FPM_CUSTOM_LOGFILE', 'php://stdout')));


// --------------------------------------------------------------------
// Setup db ORM
// --------------------------------------------------------------------

$mysqlClient = new Illuminate\Database\Capsule\Manager;

$mysqlClient->addConnection([
    'driver'    => DB_DRIVER,
    'charset'   => DB_CHARSET,
    'collation' => DB_COLLATION,
    'host'      => env('MYSQL_CONNECTION'),
    'username'  => env('MYSQL_USER'),
    'password'  => env('MYSQL_PASS'),
    'database'  => env('MYSQL_DB')
]);

//boot di Eloquent
$mysqlClient->bootEloquent();

// --------------------------------------------------------------------
// Load Services
// --------------------------------------------------------------------



