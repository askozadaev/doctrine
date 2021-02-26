<?php

declare(strict_types=1);

namespace App\Handler;

use App\Repository\AccountAndPostRepository;
use Psr\Container\ContainerInterface;

class AccountsAndPostsByAccountIdHandlerFactory
{
    public function __invoke(ContainerInterface $container): AccountAndPostByAccountIdHandler
    {
        $accountsAndPostsRepository = $container->get(AccountAndPostRepository::class);
        return new AccountAndPostByAccountIdHandler($accountsAndPostsRepository);
    }
}
