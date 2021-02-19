<?php

declare(strict_types=1);

namespace App\Handler;

use App\Repository\AccountAndPostRepository;
use Psr\Container\ContainerInterface;
use Doctrine\ORM\EntityManagerInterface;

class AccountAddAccountHandlerFactory
{
    public function __invoke(ContainerInterface $container) : AccountAddAccountHandler
    {
        $em = $container->get(EntityManagerInterface::class);
        $accountsAndPostsRepository = $container->get(AccountAndPostRepository::class);

        return new AccountAddAccountHandler($em, $accountsAndPostsRepository);
    }
}
