<?php


namespace App\Handler;

use App\Repository\AccountAndPostRepository;
use App\Validator\ParametersValidator;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Throwable;
use Zend\Diactoros\Response\JsonResponse;

class AccountAndPostByAccountIdHandler implements RequestHandlerInterface
{
    /**
     * @var AccountAndPostRepository
     */
    private AccountAndPostRepository $accountAndPostRepository;

    /**
     * AccountAndPostHandler constructor.
     * @param AccountAndPostRepository $accountAndPostRepository
     */
    public function __construct(AccountAndPostRepository $accountAndPostRepository)
    {
        $this->accountAndPostRepository = $accountAndPostRepository;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $PARAM_1_NAME = 'accountId';
        try {
            $paramValidator = new ParametersValidator();
            $paramValidator->validate($request, [$PARAM_1_NAME]);
            if ($paramValidator->isValid()) {
                $accountId = $request
                    ->getQueryParams()[$PARAM_1_NAME];
                $accountAndPostResult = $this
                    ->accountAndPostRepository
                    ->getAccountsAndPostsByAccountId($accountId);
                return new JsonResponse($accountAndPostResult);
            } else {
                return (new JsonResponse("A error! The quantity of parameters does not match"))->withStatus(400);
            }
        } catch (Throwable $ex) {
            return (new JsonResponse("A error! Bad Request"))->withStatus(400);
        }
    }
}
