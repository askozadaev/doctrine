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
     * @ORM\OneToOne(targetEntity="App\Entity\Post")
     * @ORM\JoinColumn(name="postid", referencedColumnName="id")
     * @var Post
     */
    private $post;


    /**
     * Application constructor.
     * @param $fullName
     * @param $postId
     */
    public function __construct()
    {
        $a = func_get_args();
        $i = func_num_args();
        switch ($i) {
            case 0:
                break;
            case 1:
                $fullName ="";
                $this->$fullName = $a[1];
                break;
            case 2:
                $fullName = "";
                $postId = -1;
                $this->$fullName = $a[1];
                $this->$postId = $a[2];
                break;
        }
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
     * @return Post
     */
    public function getPost(): Post
    {
        return $this->post;
    }

    /**
     * @param mixed $post
     */
    public function setPost(Post $post): void
    {
        $this->post = $post;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'fullName' => $this->fullName,
            'post' => $this->post->getName()
        ];
    }
}
