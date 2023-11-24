<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommunityController extends AbstractController
{
    #[Route('/communaute', name: 'app_community')]
    public function index(): Response
    {
        return $this->render('community/index.html.twig');
    }
}
