<?php


namespace App\Handler;

use App\Repository\AccountAndPostRepository;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;

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
//        $accountId = $request->getAttribute('accountId', false);
        $accountId =$request->getQueryParams()['accountId'];
//        var_dump($accountId); die();
        $accountAndPostResult = $this->accountAndPostRepository->getAccountsAndPostsByAccountId($accountId);
        return new JsonResponse($accountAndPostResult);
    }
}
