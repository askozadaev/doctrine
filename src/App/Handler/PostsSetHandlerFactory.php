<?php

declare(strict_types=1);

namespace App\Handler;

use App\Repository\PostRepository;
use Psr\Container\ContainerInterface;
use Doctrine\ORM\EntityManagerInterface;

class PostsSetHandlerFactory
{
    public function __invoke(ContainerInterface $container) : PostsSetHandler
    {
        $em = $container->get(EntityManagerInterface::class);
        $postsRepository = $container->get(PostRepository::class);
        return new PostsSetHandler($em, $postsRepository);
    }
}
