<?php

// --------------------------------------------------------------------
// Define Controllers
// --------------------------------------------------------------------

$app['posts.controller'] = function() use ($app) {
    return new Test0\Http\Controller\PostController($app->getService('PostService'));
};

// --------------------------------------------------------------------
// Routes Definition
// --------------------------------------------------------------------

$app->get('/v1/posts', 'posts.controller:index');
// $app->get('/v1/posts/{postId}', 'posts.controller:find');

$app->post('/v1/posts', 'posts.controller:create');
$app->put('/v1/posts', 'posts.controller:');
$app->delete('/v1/posts', 'posts.controller:');