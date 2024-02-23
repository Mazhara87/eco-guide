<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    #[Route('/blog', name: 'app_blog')]
    public function index(ArticleRepository $articleRepository): Response
    {
       $articles = $articleRepository->findAll();

        return $this->render('blog/index.html.twig', [
            "articles" => $articles
        ]);
    }

    // #[Route('/blog/{id}', name: 'app_blog_post')]
    // public function show(int $id, ArticleRepository $articleRepository): Response
    // {

        // Логика для отображения отдельного поста (если нужно)
    // }
}