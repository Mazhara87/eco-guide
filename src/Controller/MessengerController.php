<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Message; // Используйте сущность Message
use App\Form\MessengerMessageType; // Используйте форму MessengerMessageType
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface; // Импортируем EntityManagerInterface

class MessengerController extends AbstractController
{
    private EntityManagerInterface $entityManager; // Внедряем EntityManager

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route("/messenger", name: "messenger_index")]
    public function index(): Response
    {
        $messages = $this->entityManager->getRepository(Message::class)->findAll();
        dump($messages); // Добавьте эту строку
        return $this->render('messenger/index.html.twig', ['messages' => $messages]);
    }

    #[Route("/messenger/create", name: "messenger_create", methods: ["GET", "POST"])]
    public function create(Request $request): Response
    {
        $message = new Message(); // Используйте сущность Message
        $form = $this->createForm(MessengerMessageType::class, $message);

        $form->handleRequest($request);
        dump($form->getData()); // Добавьте эту строку

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($message);
            $this->entityManager->flush();

            return $this->redirectToRoute('messenger_index');
        }

        return $this->render('messenger/create.html.twig', ['form' => $form->createView()]);
    }
}
