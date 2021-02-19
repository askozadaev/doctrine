<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="accountandpost")
 */
class AccountAndPost implements \JsonSerializable
{

    /**
     * @ORM\Id
     * @ORM\Column(name="account_id", type="integer")
     * @var int
     */
    private $account_id;
    /**
     * @ORM\Id
     * @ORM\Column(name="account_fullname", type="string", length=40)
     * @var string
     */
    private $account_fullname;
    /**
     * @ORM\Id
     * @ORM\Column(name="account_post_id", type="integer")
     * @var int
     */
    private $account_post_id;
    /**
     * @ORM\Id
     * @ORM\Column(name="post_name", type="string", length=40)
     * @var string
     */
    private $post_name;

    /**
     * AccountAndPost constructor.
     * @param int $account_id
     * @param string $account_fullname
     * @param int $account_post_id
     * @param string $post_name
     */
    public function __construct(int $account_id, string $account_fullname, int $account_post_id, string $post_name)
    {
        $this->$account_id = $account_id;
        $this->$account_fullname = $account_fullname;
        $this->$account_post_id = $account_post_id;
        $this->$post_name = $post_name;
    }

    public function jsonSerialize(): array
    {
        return [
            'account_id' => $this->account_id,
            'account_fullname' => $this->account_fullname,
            'account_post_id' => $this->account_post_id,
            'post_name' => $this->post_name
        ];
    }
}
