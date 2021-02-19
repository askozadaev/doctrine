<?php


declare(strict_types=1);

namespace App\Repository;

use App\Entity\AccountAndPost;
use Doctrine\ORM\EntityManagerInterface;
use Zend\Filter\StringToLower;

class AccountAndPostRepository
{
    public const ENTITY_CLASS_NAME = AccountAndPost::class;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * AccountAndPostRepository constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getAccountsAndPostsAll(): ?array
    {
        $sql = <<<SQL
SELECT	acc.id as account_id,
          acc.fullname as account_fullname,
          acc.postid as account_post_id,
          pst.name as post_name
FROM public.account acc
         INNER JOIN public.post pst
                    ON acc.postid = pst.id;
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
    }

    public function getAccountsAndPostsByAccountId(int $accountId): ?array
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
    }
    public function setAccounts(array $data): ?bool
    {

        $accountId = (new StringToLower('UTF-8'))->filter($data['accountId']);
        $fullname = (new StringToLower('UTF-8'))->filter($data['fullname']);
        $postid = (new StringToLower('UTF-8'))->filter($data['postid']);
        $sql = <<<SQL
INSERT INTO public.account(
	id, fullname, postid)
	VALUES (:id, :fullname, :postid);
SQL;
        $result = false;
        try {
            $stmt = $this
                ->entityManager
                ->getConnection()
                ->prepare($sql);
            $stmt->bindParam(':id', $accountId);
            $stmt->bindParam(':fullname', $fullname);
            $stmt->bindParam(':postid', $postid);
            $stmt->execute();
            $result = true;
        } catch (Exception $ex) {
            throw new RuntimeException($ex->getMessage());
        }
        return $result;
    }
}
