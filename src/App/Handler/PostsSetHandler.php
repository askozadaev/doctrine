<?php


namespace App\Handler;

use App\Entity\Post;
use App\Repository\PostRepository;
use App\Validator\ParametersValidator;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Throwable;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Json\Json;

class PostsSetHandler implements RequestHandlerInterface
{


    /**
     * @var PostRepository
     */

    private PostRepository $postRepository;
    private EntityManagerInterface $manager;

    /**
     * PostsSetHandler constructor.
     * @param EntityManagerInterface $manager
     * @param PostRepository $postRepository
     */
    public function __construct(
        EntityManagerInterface $manager,
        PostRepository $postRepository
    ) {
        $this->manager = $manager;
        $this->postRepository = $postRepository;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $PARAM_1_NAME = 'postName';
        try {
            $paramValidator = new ParametersValidator();
            $paramValidator->validate($request, [$PARAM_1_NAME]);
            if ($paramValidator->isValid()) {
                $param = json_decode($request->getBody()->getContents())->{$PARAM_1_NAME};
                $post = new Post();
                $post->setName($param);
                $this->manager->persist($post);
                $this->manager->flush();
                $responseBody = [
                    'data' => $post,
                ];
                return new JsonResponse($responseBody);
            } else {
                return (new JsonResponse("A error! The quantity of parameters does not match"))->withStatus(400);
            }
        } catch (UniqueConstraintViolationException $e) {
            return (new JsonResponse("A error! This post name already exists"))->withStatus(400);
        } catch (Throwable $ex) {
            return (new JsonResponse("A error! Bad request"))->withStatus(500);
        }
    }
}
