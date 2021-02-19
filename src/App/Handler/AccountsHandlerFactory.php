<?php

declare(strict_types=1);

namespace App\Handler;

use App\Repository\AccountRepository;
use Psr\Container\ContainerInterface;
use Doctrine\ORM\EntityManagerInterface;

class AccountsHandlerFactory
{
    public function __invoke(ContainerInterface $container) : AccountsHandler
    {
        $em = $container->get(EntityManagerInterface::class);
        $accountRepository = $container->get(AccountRepository::class);

        return new AccountsHandler($em, $accountRepository);
    }
}
