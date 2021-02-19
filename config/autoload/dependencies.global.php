<?php

declare(strict_types=1);

use Zend\Expressive\Authentication\AuthenticationInterface;
use Zend\Expressive\Authentication\Basic;
use Zend\Expressive\Authentication\UserRepositoryInterface;
use Zend\Expressive\Authentication\UserRepository;

return [
    // Provides application-wide services.
    // We recommend using fully-qualified class names whenever possible as
    // service names.
    'dependencies' => [
        'abstract_factories' => [
            // Fully\Qualified\ClassOrInterfaceName::class
        ],
        'aliases' => [
            // Fully\Qualified\ClassOrInterfaceName::class => Fully\Qualified\ClassName::class,
        ],
        'delegators' => [
            \Zend\Expressive\Application::class => [
                \Zend\Expressive\Container\ApplicationConfigInjectionDelegator::class,
            ],
        ],
        'invokables' => [
            // Fully\Qualified\InterfaceName::class => Fully\Qualified\ClassName::class,
            \Doctrine\DBAL\Logging\DebugStack::class => \Doctrine\DBAL\Logging\DebugStack::class,
        ],
        'factories'  => [
            // Fully\Qualified\ClassName::class => Fully\Qualified\FactoryName::class,
            \Doctrine\ORM\EntityManagerInterface::class => \ContainerInteropDoctrine\EntityManagerFactory::class,
        ],
    ],
];
