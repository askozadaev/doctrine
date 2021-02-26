<?php


namespace App\Handler;

use App\Repository\AccountAndPostRepository;
use App\Validator\ParametersValidator;
use Doctrine\ORM\EntityManager;
use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;

class AccountAndPostAllHandler implements RequestHandlerInterface
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
        $paramValidator = new ParametersValidator();
        $paramValidator->validate($request, []);
        if ($paramValidator->isValid()) {
            try {
                $accountAndPostResult = $this->accountAndPostRepository->getAccountsAndPostsAll();
                return new JsonResponse($accountAndPostResult);
            } catch (Exception $ex) {
                return (new JsonResponse("A error! Bed Request"))->withStatus(400);
            }
        } else {
            return (new JsonResponse("A error! The quantity of parameters does not match"))->withStatus(400);
        }
    }
}
