<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\AccountJoinedPost;
use Doctrine\ORM\Query\Expr\Join;

class AccountRepository
{
    public const ENTITY_CLASS_NAME = AccountJoinedPost::class;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getAccountsAll(): ?array
    {
        try {
            return $this
                ->entityManager
                ->createQueryBuilder()
                ->select('a')
                ->from(AccountJoinedPost::class, 'a')

                ->getQuery()
                ->getArrayResult();
        } catch (\Exception $ex) {
            var_dump($ex->getMessage());
            die();
            return [];
        }
    }
}
