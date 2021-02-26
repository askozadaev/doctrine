<?php

declare(strict_types=1);

namespace App\Repository;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Post;
use Zend\Filter\StringToLower;

class PostRepository
{
    public const ENTITY_CLASS_NAME = Post::class;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getPostsAll(): ?array
    {
        try {
            return $pst = $this
                ->entityManager
                ->createQueryBuilder()
                ->select('a')
                ->from(Post::class, 'a')
                ->getQuery()
                ->getArrayResult();
        } catch (Exception $ex) {
            throw new RuntimeException($ex->getMessage());
        }
    }
    public function setPost(string $postName): bool
    {
        try {
            $post = new Post();
            $post->setName($postName);
            $this->entityManager->persist($post);
            $this->entityManager->flush();
            return true;
        } catch (\Exception $ex) {
            return false;
        }
    }
}
