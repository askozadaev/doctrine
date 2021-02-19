<?php

declare(strict_types=1);

namespace App\Handler;

use App\Repository\AccountAndPostRepository;
use Psr\Container\ContainerInterface;
use Doctrine\ORM\EntityManagerInterface;

class AccountsAndPostsAllHandlerFactory
{
    public function __invoke(ContainerInterface $container) : AccountAndPostAllHandler
    {
        $em = $container->get(EntityManagerInterface::class);
        $accountsAndPostsRepository = $container->get(AccountAndPostRepository::class);

        return new AccountAndPostAllHandler($em, $accountsAndPostsRepository);
    }
}
