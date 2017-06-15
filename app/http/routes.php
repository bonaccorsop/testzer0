<?php

// --------------------------------------------------------------------
// Define Controllers and Middlewares
// --------------------------------------------------------------------

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\JsonResponse;

$authService = $app->getService('AuthService');

$app['post.controller'] = function() use ($app) {
    $postService = $app->getService('PostService');
    return new Test0\Http\Controller\PostController($app, $postService);
};

$app['user.controller'] = function() use ($app, $authService) {
    return new Test0\Http\Controller\UserController($app, $authService);
};

$app['auth'] = function() use ($app, $authService) {
    return new Test0\Http\Middleware\AuthMiddleware($app, $authService);
};



// --------------------------------------------------------------------
// Auth Routes
// --------------------------------------------------------------------

$app->post('/login',            'user.controller:login');
$app->delete('/logout',         'user.controller:logout');

$app->get('/auth',              'user.controller:test')->before('auth:run');


// --------------------------------------------------------------------
// Business Logic Routes
// --------------------------------------------------------------------

$app->get('/posts',             'post.controller:index');
$app->get('/posts/{postId}',    'post.controller:find');

$app->post('/posts',            'post.controller:create');
$app->put('/posts',             'post.controller:update');
$app->delete('/posts',          'post.controller:delete');

