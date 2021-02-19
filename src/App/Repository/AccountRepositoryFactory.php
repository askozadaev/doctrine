<?php

declare(strict_types=1);

namespace App\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;

class AccountRepositoryFactory
{
    public function __invoke(ContainerInterface $container) : AccountRepository
    {
        return new AccountRepository(
            $container->get(EntityManagerInterface::class)
        );
    }
}
