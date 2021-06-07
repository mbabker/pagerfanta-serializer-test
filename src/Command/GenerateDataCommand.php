<?php

namespace App\Command;

use App\Entity\Comment;
use App\Entity\Post;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:generate-data')]
final class GenerateDataCommand extends Command
{
    public function __construct(private ManagerRegistry $doctrine)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $postEm = $this->doctrine->getManagerForClass(Post::class);

        for ($i = 1; $i <= 50; $i++) {
            $post = Post::createPost("Post #$i");

            for ($j = 1; $j <= 50; $j++) {
                $comment = Comment::createCommentForPost($post, "Comment #$j on {$post->title}");

                $post->addComment($comment);
            }

            $postEm->persist($post);
            $postEm->flush();
        }

        return Command::SUCCESS;
    }
}
