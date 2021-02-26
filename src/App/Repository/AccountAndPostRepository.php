<?php


declare(strict_types=1);

namespace App\Repository;

use App\Entity\AccountJoinedPost;
use App\Entity\Account;
use App\Entity\AccountAndPost;
use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Zend\Filter\StringToLower;

class AccountAndPostRepository
{
    public const ENTITY_CLASS_NAME = AccountJoinedPost::class;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @return object
     * @var EntityManagerInterface
     */
    public function find(string $identification): ?object
    {
        return $object = $this
            ->entityManager
            ->getRepository(static::ENTITY_CLASS_NAME)
            ->findOneBy(['id' => $identification]);
    }

    /**
     * AccountAndPostRepository constructor.
     * @param EntityManagerInterface $entityManager
     */

    /**
     * @var QueryBuilder
     */
    protected $queryBuilder;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getAccountsAndPostsAll(): ?array //Paginator
    {
        try {
            $queryBuilder = $this
                ->entityManager
                ->createQueryBuilder()
                ->select('a')
                ->from(AccountJoinedPost::class, 'a')
                ->leftJoin(
                    Post::class,
                    'p',
                    'WITH',
                    'a.post = p'
                );
            return $queryBuilder
                ->getQuery()
                ->getResult();
        } catch (\Exception $ex) {
            return [];
        }
    }

    public function getAccountsAndPostsByAccountId(int $accountId): array
    {
        try {
            $queryBuilder = $this
                ->entityManager
                ->createQueryBuilder()
                ->select('a')
                ->where('a.id = :accountId')
                ->setParameter('accountId', $accountId)
                ->from(AccountJoinedPost::class, 'a')
                ->leftJoin(
                    Post::class,
                    'p',
                    'WITH',
                    'a.post = p'
                );
            return $queryBuilder
                ->getQuery()
                ->getResult();
        } catch (\Exception $ex) {
            var_dump($ex->getTraceAsString());
            return [];
        }
    }

    public function setAccounts($fullName, $postId)
    {
        try {
            $acc = new Account();
            $acc->setFullName($fullName);
            $acc->setPostId($postId);
            $this->entityManager->persist($acc);
            $this->entityManager->flush();
            return true;
        } catch (\Exception $ex) {
            var_dump($ex->getMessage());
            return false;
        }
    }
}
