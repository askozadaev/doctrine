<?php


namespace App\Handler;

use App\Repository\PostRepository;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Expressive\Template\TemplateRendererInterface;

class PostsHandler implements RequestHandlerInterface
{
    /** @var string */
    private $containerName;

    /** @var Router\RouterInterface */
    private $router;

    /** @var null|TemplateRendererInterface */
    private $template;

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

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $postResult = $this->postRepository->getPostsAll();
        return new JsonResponse($postResult);
    }
}