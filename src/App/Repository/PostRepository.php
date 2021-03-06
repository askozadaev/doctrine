<?php

declare(strict_types=1);

namespace App\Repository;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Post;
use Zend\Filter\StringToLower;

class PostRepository
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

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
}
