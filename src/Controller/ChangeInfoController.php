<?php
// src/Controller/ChangeInfoController.php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\ChangeInfoType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface; // Добавлен новый use



class ChangeInfoController extends AbstractController
{
    
     #[Route("/change-info", name:"app_change_info")]
     public function changeInfo(Request $request, EntityManagerInterface $entityManager)
{
    $user = $this->getUser(); // Получаем текущего пользователя

    $form = $this->createForm(ChangeInfoType::class, $user);

    // Обработка запроса
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // Обновляем данные в таблице
        $entityManager->flush();

        // Добавьте любой код редиректа или другой обработки после успешного обновления
    }

    // Возвращаем шаблон с формой
    return $this->render('change_info/index.html.twig', [
        'form' => $form->createView(),
    ]);
}

 /**
     * @Route("/change-info", name="app_change_info")
     */
    public function updateUserInfo(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = $this->getUser(); // Получаем текущего пользователя

        $form = $this->createForm(ChangeInfoType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Шифруем пароль перед сохранением в базу данных
            $encodedPassword = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($encodedPassword);

            $entityManager->flush();

            // Добавьте код редиректа или другой обработки после успешного обновления
        }

        return $this->render('change_info/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
?>