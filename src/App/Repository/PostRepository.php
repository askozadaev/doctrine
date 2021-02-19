<?php

declare(strict_types=1);

namespace App\Repository;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Post;

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
        $sql = <<<SQL
    SELECT id, name
	FROM public.post;
SQL;
        try {
            $stmt = $this
                ->entityManager
                ->getConnection()
                ->prepare($sql);
//        $stmt->bindParam(':id', $purchaseId);
            $stmt->execute();
        } catch (Exception $ex) {
            throw new RuntimeException($ex->getMessage());
        }

        return $stmt->fetchAll();
    }
}
