<?php


namespace App\Handler;

use App\Entity\Account;
use App\Entity\AccountAndPost;
use App\Exception\RuntimeException;
use App\Repository\AccountAndPostRepository;
use App\Validator\ParametersValidator;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;

class AccountAddAccountHandler implements RequestHandlerInterface
{
    /**
     * @var AccountAndPostRepository
     */
    private AccountAndPostRepository $accountAndPostRepository;
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $manager;

    /**
     * AccountAndPostHandler constructor.
     * @param EntityManagerInterface $manager
     * @param AccountAndPostRepository $accountAndPostRepository
     */
    public function __construct(
        EntityManagerInterface $manager,
        AccountAndPostRepository $accountAndPostRepository
    ) {

        $this->accountAndPostRepository = $accountAndPostRepository;
        $this->manager = $manager;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $PARAM_1_NAME = 'fullName';
        $PARAM_2_NAME = 'postId';
        $paramValidator = new ParametersValidator();
        $paramValidator->validate($request, [$PARAM_1_NAME, $PARAM_2_NAME]);
        if ($paramValidator->isValid()) {
            $fullName = json_decode($request->getBody()->getContents())->{$PARAM_1_NAME};
            $postId = json_decode($request->getBody()->getContents())->{$PARAM_2_NAME};
            try {
//                $accountAndPostResult = $this->accountAndPostRepository->setAccounts($fullName, $postId);
                $acc = new Account();
                $acc->setFullName($fullName);
                $acc->setPostId($postId);
                $this->manager->persist($acc);
                $this->manager->flush();
                $responseBody = [
                    'data' => $acc,
                ];
                return new JsonResponse($responseBody);
            } catch (ORMException $e) {
                return (new JsonResponse("A error! DB Error"))->withStatus(500);
            } catch (Exception $ex) {
                return (new JsonResponse("A error! Bad Request"))->withStatus(400);
            }
        } else {
            return (new JsonResponse("A error! The quantity of parameters does not match"))->withStatus(400);
        }
    }
}
