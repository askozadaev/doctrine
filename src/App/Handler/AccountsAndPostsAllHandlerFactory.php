<?php

declare(strict_types=1);

namespace App\Handler;

use App\Repository\AccountAndPostRepository;
use Psr\Container\ContainerInterface;

class AccountsAndPostsAllHandlerFactory
{
    public function __invoke(ContainerInterface $container): AccountAndPostAllHandler
    {
        $accountsAndPostsRepository = $container->get(AccountAndPostRepository::class);
        return new AccountAndPostAllHandler($accountsAndPostsRepository);
    }
}
