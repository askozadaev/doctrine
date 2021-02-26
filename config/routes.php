<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Zend\Expressive\Application;
use Zend\Expressive\MiddlewareFactory;

/**
 * Setup routes with a single request method:
 *
 * $app->get('/', App\Handler\HomePageHandler::class, 'home');
 * $app->post('/album', App\Handler\AlbumCreateHandler::class, 'album.create');
 * $app->put('/album/:id', App\Handler\AlbumUpdateHandler::class, 'album.put');
 * $app->patch('/album/:id', App\Handler\AlbumUpdateHandler::class, 'album.patch');
 * $app->delete('/album/:id', App\Handler\AlbumDeleteHandler::class, 'album.delete');
 *
 * Or with multiple request methods:
 *
 * $app->route('/contact', App\Handler\ContactHandler::class, ['GET', 'POST', ...], 'contact');
 *
 * Or handling all request methods:
 *
 * $app->route('/contact', App\Handler\ContactHandler::class)->setName('contact');
 *
 * or:
 *
 * $app->route(
 *     '/contact',
 *     App\Handler\ContactHandler::class,
 *     Zend\Expressive\Router\Route::HTTP_METHOD_ANY,
 *     'contact'
 * );
 */
return function (Application $app, MiddlewareFactory $factory, ContainerInterface $container) : void {
    $app->get('/', App\Handler\HomePageHandler::class, 'home');
    $app->get('/api/ping', App\Handler\PingHandler::class, 'api.ping');
    $app->get('/v1/users/', App\Handler\AccountAndPostAllHandler::class, 'v1accountsadnpostsbyid');
    $app->get('/v1/postsall', App\Handler\PostsHandler::class, 'postsall');
    $app->post('/v1/setpost', App\Handler\PostsSetHandler::class, 'v1setpost');
    $app->post('/v1/accountsposts/addaccount', App\Handler\AccountAddAccountHandler::class, 'accountaddaccount');
    $app->get('/v1/accounts', App\Handler\AccountsHandler::class, 'accounts');
    $app->get('/v1/getaccountsandpost', App\Handler\AccountAndPostAllHandler::class, 'accountandpostall');
    $app->get('/v1/accountsposts/byid', App\Handler\AccountAndPostByAccountIdHandler::class, 'accountsadnpostsbyid');
};
