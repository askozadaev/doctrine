<?php


namespace App\Handler;

use App\Repository\PostRepository;
use App\Validator\ParametersValidator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Throwable;
use Zend\Diactoros\Response\JsonResponse;

class PostsHandler implements RequestHandlerInterface
{
    /**
     * @var PostRepository
     */
    private PostRepository $postRepository;

    public function __construct(
        PostRepository $postRepository
    ) {
        $this->postRepository = $postRepository;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $paramValidator = new ParametersValidator();
            $paramValidator->validate($request, []);
            if ($paramValidator->isValid()) {
                $postResult = $this->postRepository->getPostsAll();
                return new JsonResponse($postResult);
            } else {
                return (new JsonResponse("A error! The quantity of parameters does not match"))->withStatus(400);
            }
        } catch (Throwable $ex) {
            return (new JsonResponse("A error! Bad Request"))->withStatus(400);
        }
    }
}
