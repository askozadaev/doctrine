<?php

declare(strict_types=1);

namespace App;

use App\Repository\AccountAndPostRepository;
use App\Repository\AccountAndPostRepositoryFactory;
use App\Repository\AccountRepository;
use App\Repository\AccountRepositoryFactory;
use App\Repository\PostRepository;
use App\Repository\PostRepositoryFactory;

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
}
