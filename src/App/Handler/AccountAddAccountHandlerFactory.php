<?php

declare(strict_types=1);

namespace App\Handler;

use App\Repository\AccountAndPostRepository;
use Psr\Container\ContainerInterface;

class AccountAddAccountHandlerFactory
{
    public function __invoke(ContainerInterface $container): AccountAddAccountHandler
    {
        $accountsAndPostsRepository = $container->get(AccountAndPostRepository::class);
        return new AccountAddAccountHandler($accountsAndPostsRepository);
    }
}
