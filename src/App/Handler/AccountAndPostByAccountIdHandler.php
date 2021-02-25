<?php


namespace App\Handler;

use App\Repository\AccountAndPostRepository;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;
use App\Validator\EmptyParametrValidator;

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
        $emptyParametrValidator = new EmptyParametrValidator();
        $emptyParametrValidator->validate($request, [$PARAM_1_NAME]);
        if ($emptyParametrValidator->isValid()) {
            $accountId =$request->getQueryParams()[$PARAM_1_NAME];
            $accountAndPostResult = $this->accountAndPostRepository->getAccountsAndPostsByAccountId($accountId);
            return new JsonResponse($accountAndPostResult);
        } else {
                return (new JsonResponse("A error! The quantity of parameters does not match"))->withStatus(400);
        }


//        $accmw = $request->getAttribute(Middleware::ACCOUNT_AND_POST);

/*        var_dump($accountAndPostResult->jsonSerialize());
        die();*/
    }
}
