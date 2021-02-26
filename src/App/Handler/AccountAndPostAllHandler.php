<?php


namespace App\Handler;

use App\Repository\AccountAndPostRepository;
use App\Validator\ParametrValidator;
use Doctrine\ORM\EntityManager;
use phpDocumentor\Reflection\Types\Array_;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;

class AccountAndPostAllHandler implements RequestHandlerInterface
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
        $paramValidator = new ParametrValidator();
        $paramValidator->validate($request, []);
        if ($paramValidator->isValid()) {
            try {
                $accountAndPostResult = $this->accountAndPostRepository->getAccountsAndPostsAll();
                return new JsonResponse($accountAndPostResult);
            } catch (\Exception $ex) {
                return (new JsonResponse("A error! Bed Request"))->withStatus(400);
            }
        } else {
            return (new JsonResponse("A error! The quantity of parameters does not match"))->withStatus(400);
        }
    }
}
