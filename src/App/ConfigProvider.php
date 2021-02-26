<?php

declare(strict_types=1);

namespace App;

use App\Handler\AccountAddAccountHandler;
use App\Handler\AccountAndPostAllHandler;
use App\Handler\AccountAndPostByAccountIdHandler;
use App\Handler\AccountsHandler;
use App\Handler\PingHandler;
use App\Handler\PostsHandler;
use App\Handler\PostsSetHandler;
use App\Repository\AccountAndPostRepository;
use App\Repository\AccountAndPostRepositoryFactory;
use App\Repository\AccountRepository;
use App\Repository\AccountRepositoryFactory;
use App\Repository\PostRepository;
use App\Repository\PostRepositoryFactory;
use App\Handler\HomePageHandler;

/**
 * The configuration provider for the App module
 *
 * @see https://docs.zendframework.com/zend-component-installer/
 */
class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     *
     */
    public function __invoke() : array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'templates'    => $this->getTemplates(),
            'doctrine' => $this->getDoctrine(),
            'routes' => $this->getRoutes(),
        ];
    }

    /**
     * Returns the container dependencies
     */
    public function getDependencies() : array
    {
        return [
            'invokables' => [
                Handler\PingHandler::class => Handler\PingHandler::class,
            ],
            'factories'  => [
                Handler\HomePageHandler::class => Handler\HomePageHandlerFactory::class,
                Handler\AccountsHandler::class => Handler\AccountsHandlerFactory::class,
                Handler\PostsHandler::class => Handler\PostsHandlerFactory::class,
                Handler\PostsSetHandler::class => Handler\PostsSetHandlerFactory::class,
                Handler\AccountAndPostAllHandler::class => Handler\AccountsAndPostsAllHandlerFactory::class,
                Handler\AccountAndPostByAccountIdHandler::class => Handler\AccountsAndPostsByAccountIdHandlerFactory::class,
                Handler\AccountAddAccountHandler::class => Handler\AccountAddAccountHandlerFactory::class,
                AccountRepository::class => AccountRepositoryFactory::class,
                AccountAndPostRepository::class => AccountAndPostRepositoryFactory::class,
                PostRepository::class => PostRepositoryFactory::class
            ],
        ];
    }

    /**
     * Returns the templates configuration
     */
    public function getTemplates() : array
    {
        return [
            'paths' => [
                'app'    => ['templates/app'],
                'error'  => ['templates/error'],
                'layout' => ['templates/layout'],
            ],
        ];
    }

    public function getDoctrine(): array
    {
        return [
            'driver' => [
                'orm_default' => [
                    'drivers' => [
                        'App\Entity' => 'app_entity',
                    ],
                ],
                'app_entity' => [
                    'class' => SimplifiedXmlDriver::class,
                    'cache' => 'array',
                    'paths' => [
                        __DIR__ . '/Doctrine' => 'App\Entity',
                    ],
                ],
            ],
        ];
    }

    private function getRoutes() : array
    {
        return [
            [
                'name' => 'home',
                'path' => '/',
                'allowed_methods' => ['GET'],
                'middleware' => HomePageHandler::class,
            ],
            [
                'name' => 'api.ping',
                'path' => '/api/ping',
                'allowed_methods' => ['GET'],
                'middleware' => PingHandler::class,
            ],            [
                'name' => 'v1.accounts.adn.posts.byid',
                'path' => '/v1/users/',
                'allowed_methods' => ['GET'],
                'middleware' => AccountAndPostAllHandler::class,
            ],
            [
                'name' => 'v1.posts.all',
                'path' => '/v1/postsall',
                'allowed_methods' => ['GET'],
                'middleware' => PostsHandler::class,
            ],
            [
                'name' => 'v1.set.post',
                'path' => '/v1/setpost',
                'allowed_methods' => ['POST'],
                'middleware' => PostsSetHandler::class,
            ],
            [
                'name' => 'v1.accounts.add.account',
                'path' => '/v1/accountsposts/addaccount',
                'allowed_methods' => ['POST'],
                'middleware' => AccountAddAccountHandler::class,
            ],
            [
                'name' => 'v1.accounts',
                'path' => '/v1/accounts',
                'allowed_methods' => ['GET'],
                'middleware' => AccountsHandler::class,
            ],
            [
                'name' => 'v1.accounts.posts.byid',
                'path' => '/v1/accountsposts/byid',
                'allowed_methods' => ['GET'],
                'middleware' => AccountAndPostByAccountIdHandler::class,
            ],
            [
                'name' => 'v1.getaccounts.and.post',
                'path' => '/v1/getaccountsandpost',
                'allowed_methods' => ['GET'],
                'middleware' => AccountAndPostAllHandler::class,
            ],
        ];
    }
}
