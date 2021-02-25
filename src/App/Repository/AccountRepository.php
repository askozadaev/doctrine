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
//            var_dump("text");
//            die();
            return $this
                ->entityManager
                ->createQueryBuilder()
                ->select('a')
                ->from(AccountJoinedPost::class, 'a')
/*                ->leftJoin(
                    Post::class,
                    'p',
                    Join::WITH,
                    'a.post = p'
                )*/
                ->getQuery()
                ->getArrayResult();
        } catch (\Exception $ex) {
            var_dump($ex->getMessage());
            die();
            return [];
        }
    }

    /*
    public function getAccountsAll(): ?array
    {
        $sql = <<<SQL
    SELECT id, fullname, postid
    FROM public.account;
SQL;
        try {
            $stmt = $this
                ->entityManager
                ->getConnection()
                ->prepare($sql);
            $stmt->execute();
        } catch (Exception $ex) {
            throw new RuntimeException($ex->getMessage());
        }

        return $stmt->fetchAll();
    }*/
}
