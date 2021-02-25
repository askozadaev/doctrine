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
/*            var_dump($queryBuilder->getQuery()->getDQL());
            die();*/
            return $queryBuilder
                ->getQuery()
                ->getResult();
        } catch (\Exception $ex) {
            var_dump($ex->getTraceAsString());
            return [];
        }
    }



    public function getAccountsAndPostsByAccountId(int $accountId): ?array //TODO Вернуть joined сущьность
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
            /*            var_dump($queryBuilder->getQuery()->getDQL());
                        die();*/
            return $queryBuilder
                ->getQuery()
                ->getResult();
        } catch (\Exception $ex) {
            var_dump($ex->getTraceAsString());
            return [];
        }
    }
/*    public function getAccountsAndPostsByAccountId(int $accountId): ?array
    {
        $sql = <<<SQL
SELECT	acc.id as account_id,
          acc.fullname as account_fullname,
          acc.postid as account_post_id,
          pst.name as post_name
FROM public.account acc
         INNER JOIN public.post pst
                    ON acc.postid = pst.id
         WHERE acc.id = :account_id;
SQL;
        try {
            $stmt = $this
                ->entityManager
                ->getConnection()
                ->prepare($sql);
            $stmt->bindParam(':account_id', $accountId);
            $stmt->execute();
        } catch (Exception $ex) {
            throw new RuntimeException($ex->getMessage());
        }

        return $stmt->fetchAll();
    }*/
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









/*//        $accountId = (new StringToLower('UTF-8'))->filter($data['accountId']);
        $fullname = (new StringToLower('UTF-8'))->filter($data['fullname']);
        $postid = (new StringToLower('UTF-8'))->filter($data['postid']);
        $sql = <<<SQL
INSERT INTO public.account(
	fullname, postid)
	VALUES (:fullname, :postid);
SQL;
        $result = false;
        try {
            $stmt = $this
                ->entityManager
                ->getConnection()
                ->prepare($sql);
//            $stmt->bindParam(':id', $accountId);
            $stmt->bindParam(':fullname', $fullname);
            $stmt->bindParam(':postid', $postid);
            $stmt->execute();
            $result = true;
        } catch (Exception $ex) {
            throw new RuntimeException($ex->getMessage());
        }
        return $result;*/
    }

    /*public function setAccounts(string $fullName): ?bool //TODO Спросить у Димы, как реализовать
    {
        try {
            $acc = new AccountJoinedPost();
            $acc->setFullName($fullName);
            $acc->setPostId(AccountJoinedPost::POST_ROLE); // Пусть будет по умолчанию :о)
            $this->entityManager->persist($acc);
            $this->entityManager->flush();
            return true;
        } catch (\Exception $ex) {
            return false;
        }
    }*/
}
