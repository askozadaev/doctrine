<?php


namespace App\Handler;

use App\Repository\PostRepository;
use App\Validator\ParametrValidator;
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
        try {
            $paramValidator = new ParametrValidator();
            $paramValidator->validate($request, [$PARAM_1_NAME]);
            if ($paramValidator->isValid()) {
                $param = json_decode($request->getBody()->getContents())->{$PARAM_1_NAME};
                $postResult = $this->postRepository->setPost($param);
                return new JsonResponse($postResult);
            } else {
                return (new JsonResponse("A error! The quantity of parameters does not match"))->withStatus(400);
            }
        } catch (\Throwable $ex) {
            return (new JsonResponse("A error! Bad request"))->withStatus(400);
        }
    }
}
