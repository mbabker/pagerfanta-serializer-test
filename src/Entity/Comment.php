<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation as Serializer;

#[ORM\Entity]
#[ORM\Table]
class Comment
{
    #[ORM\Column(nullable: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[Serializer\Groups(['list_posts'])]
    public ?int $id = null;

    #[ORM\Column]
    #[Serializer\Groups(['list_posts'])]
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
