<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ApiPostsController extends AbstractController
{
    #[Route('/api/posts', name: 'api_posts')]
    public function index(PostRepository $postRepository): Response
    {
        return $this->json(
            new Pagerfanta(
                new QueryAdapter($postRepository->createPostListQueryBuilder())
            )
        );
    }
}
