<?php

declare(strict_types=1);

namespace App\Handler;

use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;
use App\Repository\AccountRepository;

class AccountsHandler implements RequestHandlerInterface
{

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var AccountRepository
     */
    private $accountRepository;


    public function __construct(
        EntityManager $entityManager,
        AccountRepository $accountRepository
    ) {
        $this->entityManager = $entityManager;
        $this->accountRepository = $accountRepository;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $accountsResult = $this->accountRepository->getAccountsAll();
        return new JsonResponse($accountsResult);
    }
}
