<?php

declare(strict_types=1);

namespace App\Handler;

use App\Repository\PostRepository;
use Psr\Container\ContainerInterface;

class PostsSetHandlerFactory
{
    public function __invoke(ContainerInterface $container): PostsSetHandler
    {
        $postsRepository = $container->get(PostRepository::class);
        return new PostsSetHandler($postsRepository);
    }
}
