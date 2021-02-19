<?php

declare(strict_types=1);

use Doctrine\Common\Persistence\Mapping\Driver\MappingDriverChain;
use Doctrine\DBAL\Driver\PDOPgSql\Driver;

return [
    'doctrine' => [
        'connection' => [
            'orm_default' => [
                'driver_class' => Driver::class,
                'params' => [
                    'host' => 'localhost',
                    'port' => 5432,
                    'user' => 'test_user',
                    'password' => 'test_user',
                    'dbname' => 'test_db',
                ],
            ],
        ],
        'driver' => [
            'orm_default' => [
                'class' => MappingDriverChain::class,
                'drivers' => [
                ],
            ],
        ],
        'configuration' => [
            'orm_default' => [
                'auto_generate_proxy_classes' => false,
            ],
        ],
    ],
];
