<?php

declare(strict_types=1);

namespace App\Handler;

use App\Repository\PostRepository;
use Psr\Container\ContainerInterface;
use Doctrine\ORM\EntityManagerInterface;

class PostsHandlerFactory
{
    public function __invoke(ContainerInterface $container) : PostsHandler
    {
        $postsRepository = $container->get(PostRepository::class);
        return new PostsHandler($postsRepository);
    }
}
