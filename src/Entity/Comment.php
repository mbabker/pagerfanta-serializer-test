<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table]
class Comment
{
    #[ORM\Column(nullable: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    public ?int $id = null;

    #[ORM\Column]
    public string $message;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    public Post $post;

    public static function createCommentForPost(Post $post, string $message): self
    {
        $comment = new self();
        $comment->post = $post;
        $comment->message = $message;

        return $comment;
    }
}
