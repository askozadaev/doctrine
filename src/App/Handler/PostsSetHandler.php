<?php


namespace App\Handler;

use App\Repository\PostRepository;
use App\Validator\EmptyParametrValidator;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Json\Json;

class PostsSetHandler implements RequestHandlerInterface
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var PostRepository
     */
    private $postRepository;

    public function __construct(
        EntityManager $entityManager,
        PostRepository $postRepository
    ) {
        $this->entityManager = $entityManager;
        $this->postRepository = $postRepository;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $PARAM_1_NAME = 'postName';
        $emptyParametrValidator = new EmptyParametrValidator();
        $emptyParametrValidator->validate($request, [$PARAM_1_NAME]);
        if ($emptyParametrValidator->isValid()) {
            $param = json_decode($request->getBody()->getContents())->{$PARAM_1_NAME};
            $postResult = $this->postRepository->setPost($param);
            return new JsonResponse($postResult);
        } else {
            return (new JsonResponse("A error! The quantity of parameters does not match"))->withStatus(400);
        }
    }
}
