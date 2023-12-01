<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    #[Route('/blog', name: 'app_blog')]
    public function index(): Response
    {
        $posts = [
            [
                'id' => 1,
                'title' => '10 Conseils pour un Mode de Vie Écologique',
                'content' => 'Découvrez ces 10 conseils simples pour adopter un mode de vie plus respectueux de l\'environnement. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam...',
            ],
            [
                'id' => 2,
                'title' => 'Nouvelles Technologies pour la Gestion des Déchets',
                'content' => 'Explorez les dernières avancées technologiques dans la gestion des déchets et leur impact sur notre environnement. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam...',
            ],
        ];

        return $this->render('blog/index.html.twig', [
            'posts' => $posts,
        ]);
    }

    // #[Route('/blog/{id}', name: 'app_blog_post')]
    // public function show(int $id): Response
    // {
    //     // Логика для отображения отдельного поста (если нужно)
    // }
}