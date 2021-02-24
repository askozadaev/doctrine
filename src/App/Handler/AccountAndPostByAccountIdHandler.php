<?php


namespace App\Handler;

use App\Repository\AccountAndPostRepository;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;
use App\Middleware\Middleware;

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
        $accountId =$request->getQueryParams()['accountId'];
        $accountAndPostResult = $this->accountAndPostRepository->getAccountsAndPostsByAccountId($accountId);

//        $accmw = $request->getAttribute(Middleware::ACCOUNT_AND_POST);

/*        var_dump($accountAndPostResult->jsonSerialize());
        die();*/
        return new JsonResponse($accountAndPostResult);
    }
}
