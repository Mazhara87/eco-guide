<?php
// src/Controller/LogoutController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LogoutController extends AbstractController
{
    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): void
    {
        // This method is intentionally left blank.
        // It will be intercepted by the logout key on your firewall.
    }
}