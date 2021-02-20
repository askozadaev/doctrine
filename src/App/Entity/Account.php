<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="account")
 */
class Account implements \JsonSerializable
{

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

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'fullName' => $this->fullName,
            'postId' => $this->postId
        ];
    }
}
