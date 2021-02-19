<?php


namespace App\Handler;

use App\Exception\RuntimeException;
use App\Repository\AccountAndPostRepository;
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
        try {
//            $incomingData = $this->getRequestContentsAsJson($request);
            $incomingData =  $request->getBody()->getContents();
        } catch (\Exception $e) {
//            return $this->createErrorResponse($e->getMessages(), 406);
        }
        $incomingData = json_decode($incomingData, true);
        $accountAndPostResult = $this->accountAndPostRepository->setAccounts($incomingData);
        return new JsonResponse($accountAndPostResult);
    }
}
