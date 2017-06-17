<?php

// --------------------------------------------------------------------
// Define Controllers and Middlewares
// --------------------------------------------------------------------

use Test0\Http\Application;

$app['posts'] = function(Application $app) {
    return new Test0\Http\Controller\PostController($app, $app->getService('PostService'));
};

$app['auth'] = function(Application $app) {
    return new Test0\Http\Controller\AuthController($app, $app->getService('AuthService'));
};

// --------------------------------------------------------------------
// Auth Routes
// --------------------------------------------------------------------

$app->post('/login',            'auth:login');

// --------------------------------------------------------------------
// Business Logic Routes
// --------------------------------------------------------------------

$app->get('me/posts',             'posts:index')->before('auth:middleware');
$app->get('me/posts/{postId}',    'posts:find')->before('auth:middleware');

$app->post('me/posts',            'posts:create')->before('auth:middleware');
$app->put('me/posts/{postId}',    'posts:update')->before('auth:middleware');
$app->delete('me/posts/{postId}', 'posts:delete')->before('auth:middleware');

