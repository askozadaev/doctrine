<?php


declare(strict_types=1);

namespace App\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;

class AccountAndPostRepositoryFactory
{
    public function __invoke(ContainerInterface $container): AccountAndPostRepository
    {
        return new AccountAndPostRepository(
            $container->get(EntityManagerInterface::class)
        );
    }
}
