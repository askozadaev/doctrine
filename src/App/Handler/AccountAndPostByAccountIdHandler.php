<?php


namespace App\Handler;

use App\Repository\AccountAndPostRepository;
use Doctrine\ORM\EntityManager;
use ErrorException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;
use App\Validator\ParametrValidator;

class AccountAndPostByAccountIdHandler implements RequestHandlerInterface
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var AccountAndPostRepository
     */
    private $accountAndPostRepository;

    /**
     * AccountAndPostHandler constructor.
     * @param EntityManager $entityManager
     * @param AccountAndPostRepository $accountAndPostRepository
     */
    public function __construct(EntityManager $entityManager, AccountAndPostRepository $accountAndPostRepository)
    {
        $this->entityManager = $entityManager;
        $this->accountAndPostRepository = $accountAndPostRepository;
    }
    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $PARAM_1_NAME = 'accountId';
        try {
            $paramValidator = new ParametrValidator();
            $paramValidator->validate($request, [$PARAM_1_NAME]);
            if ($paramValidator->isValid()) {
                $accountId =$request->getQueryParams()[$PARAM_1_NAME];
                $accountAndPostResult = $this->accountAndPostRepository->getAccountsAndPostsByAccountId($accountId);
                return new JsonResponse($accountAndPostResult);
            } else {
                return (new JsonResponse("A error! The quantity of parameters does not match"))->withStatus(400);
            }
        } catch (\Throwable $ex) {
            return (new JsonResponse("A error! Bad Request"))->withStatus(400);
        }
    }
}
