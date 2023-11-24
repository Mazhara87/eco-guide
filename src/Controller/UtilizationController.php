<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UtilizationController extends AbstractController
{
    #[Route('/utilization', name: 'app_utilization')]
    public function index(): Response
    {
        return $this->render('utilization/index.html.twig', [
            'controller_name' => 'UtilizationController',
        ]);
    }
}
