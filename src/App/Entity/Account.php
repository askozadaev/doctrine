<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="account")
 */
class Account implements \JsonSerializable
{
    // Константы статуса поста (роли).
    const POSTID_ADMIN       = 1; // Администратор
    const POST_ROLE   = 2; // Обычный пользователь
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="id", type="integer")
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(name="fullName", type="string", length=40)
     * @var string
     */
    private $fullName;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Post", mappedBy="post")
     * @ORM\JoinColumn(name="postId", referencedColumnName="id")
     */
    private $postId;

    /**
     * Application constructor.
     * @param $fullName
     * @param $postId
     */
    public function __construct($fullName, $postId)
    {
        $this->$fullName = $fullName;
        $this->$postId = $postId;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getFullName(): string
    {
        return $this->fullName;
    }

    /**
     * @param string $fullName
     */
    public function setFullName(string $fullName): void
    {
        $this->fullName = $fullName;
    }

    /**
     * @return mixed
     */
    public function getPostId()
    {
        return $this->postId;
    }

    /**
     * @param mixed $postId
     */
    public function setPostId($postId): void
    {
        $this->postId = $postId;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'fullName' => $this->fullName,
            'postId' => $this->postId
        ];
    }
}
