<?php

declare(strict_types=1);

namespace App\Handler;

use App\Validator\ParametrValidator;
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
        try {
            $paramValidator = new ParametrValidator();
            $paramValidator->validate($request, []);
            if ($paramValidator->isValid()) {
                $accountsResult = $this->accountRepository->getAccountsAll();
                return new JsonResponse($accountsResult);
            } else {
                return (new JsonResponse("A error! The quantity of parameters does not match"))->withStatus(400);
            }
        } catch (\Throwable $ex) {
            return (new JsonResponse("A error! Bad Request"))->withStatus(400);
        }
    }
}
