<?php

declare(strict_types=1);

namespace App\Handler;

use App\Repository\AccountRepository;
use Psr\Container\ContainerInterface;

class AccountsHandlerFactory
{
    public function __invoke(ContainerInterface $container) : AccountsHandler
    {
        $accountRepository = $container->get(AccountRepository::class);
        return new AccountsHandler($accountRepository);
    }
}
