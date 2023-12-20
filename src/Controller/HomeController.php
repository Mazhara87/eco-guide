<?php

namespace App\Controller;

use App\Repository\ForumPostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
   /* public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }*/

    public function index(ForumPostRepository $forumPostRepository): Response
    {
        $latestPosts = $forumPostRepository->findLatestPost(3);
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController', 
            'latest_posts' => $latestPosts
        ]);
    }

}