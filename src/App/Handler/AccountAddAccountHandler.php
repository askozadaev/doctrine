<?php


namespace App\Handler;

use App\Entity\AccountAndPost;
use App\Exception\RuntimeException;
use App\Repository\AccountAndPostRepository;
use App\Validator\EmptyParametrValidator;
use Doctrine\ORM\EntityManager;
use PHPUnit\Util\Json;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;

class AccountAddAccountHandler implements RequestHandlerInterface
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
        $PARAM_1_NAME = 'fullName';
        $PARAM_2_NAME = 'postId';
        $emptyParametrValidator = new EmptyParametrValidator();
        $emptyParametrValidator->validate($request, [$PARAM_1_NAME, $PARAM_2_NAME]);
        if ($emptyParametrValidator->isValid()) {
            $fullName = json_decode($request->getBody()->getContents())->{$PARAM_1_NAME};
            $postId = json_decode($request->getBody()->getContents())->{$PARAM_2_NAME};
            $accountAndPostResult = $this->accountAndPostRepository->setAccounts($fullName, $postId);
            return new JsonResponse($accountAndPostResult);
        } else {
            return (new JsonResponse("A error! The quantity of parameters does not match"))->withStatus(400);
        }
    }
}
