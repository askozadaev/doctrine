<?php

declare(strict_types=1);

namespace App\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;

class PostRepositoryFactory
{
    public function __invoke(ContainerInterface $container) : PostRepository
    {
        return new PostRepository(
            $container->get(EntityManagerInterface::class)
        );
    }
}