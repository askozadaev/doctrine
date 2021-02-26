<?php

declare(strict_types=1);

namespace App\Handler;

use App\Repository\AccountAndPostRepository;
use Psr\Container\ContainerInterface;
use Doctrine\ORM\EntityManagerInterface;

class AccountsAndPostsByAccountIdHandlerFactory
{
    public function __invoke(ContainerInterface $container) : AccountAndPostByAccountIdHandler
    {
        $em = $container->get(EntityManagerInterface::class);
        $accountsAndPostsRepository = $container->get(AccountAndPostRepository::class);
        return new AccountAndPostByAccountIdHandler($em, $accountsAndPostsRepository);
    }
}
