<?php


namespace App\Handler;

use App\Entity\AccountAndPost;
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
        $fullName = json_decode($request->getBody()->getContents())->{'fullName'};
        $postId = json_decode($request->getBody()->getContents())->{'postId'};

        $ap = $this->getAccountAndPost($postId);
        $accountAndPostResult = $this->accountAndPostRepository->setAccounts($ap);
        return new JsonResponse($accountAndPostResult);
    }

    private function getAccountAndPost(string $id) : ?AccountAndPost
    {
        if ($ap = $this->accountAndPostRepository->find($id)) {
            $ap->setDeletedAt();
            return $ap;
        }
        return null;
    }
}
