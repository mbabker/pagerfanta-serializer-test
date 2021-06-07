<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table]
class Post
{
    #[ORM\Column(nullable: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    public ?int $id = null;

    #[ORM\Column]
    public string $title;

    /**
     * @var Collection<Comment>
     */
    #[ORM\OneToMany(mappedBy: 'post', targetEntity: Comment::class, cascade: ['persist'], fetch: 'EXTRA_LAZY')]
    private Collection $comments;

    protected function __construct()
    {
        $this->comments = new ArrayCollection();
    }

    public static function createPost(string $title): self
    {
        $post = new self();
        $post->title = $title;

        return $post;
    }

    public function addComment(Comment $comment): void
    {
        if (!$this->hasComment($comment)) {
            $this->comments->add($comment);
        }
    }

    /**
     * @return Collection<Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function hasComment(Comment $comment): bool
    {
        return $this->comments->contains($comment);
    }

    public function removeComment(Comment $comment): void
    {
        if ($this->hasComment($comment)) {
            $this->comments->removeElement($comment);
        }
    }

    public function getCommentCount(): int
    {
        return count($this->comments);
    }
}