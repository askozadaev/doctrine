<?php

declare(strict_types=1);

namespace App\Handler;

use App\Repository\AccountRepository;
use App\Validator\ParametersValidator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Throwable;
use Zend\Diactoros\Response\JsonResponse;

class AccountsHandler implements RequestHandlerInterface
{
    /**
     * @var AccountRepository
     */
    private AccountRepository $accountRepository;


    public function __construct(
        AccountRepository $accountRepository
    ) {
        $this->accountRepository = $accountRepository;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $paramValidator = new ParametersValidator();
            $paramValidator->validate($request, []);
            if ($paramValidator->isValid()) {
                $accountsResult = $this->accountRepository->getAccountsAll();
                return new JsonResponse($accountsResult);
            } else {
                return (new JsonResponse("A error! The quantity of parameters does not match"))->withStatus(400);
            }
        } catch (Throwable $ex) {
            return (new JsonResponse("A error! Bad Request"))->withStatus(400);
        }
    }
}
