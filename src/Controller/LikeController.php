<?php


namespace App\Controller;

use App\Entity\Project;
use App\Entity\ProjectSupporter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;


class LikeController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/like/{projectId}', name: 'like_project')]
    public function likeProject(Request $request, $projectId, EntityManagerInterface $entityManager): Response
    {
        // Получение проекта по ID
        $project = $entityManager->getRepository(Project::class)->find($projectId);

        if (!$project) {
            // Проект не существует, вернуть ошибку или выполнить необходимые действия
            return new Response('Проект не найден', Response::HTTP_NOT_FOUND);
        }

        // Получение текущего пользователя
        $user = $this->getUser();

        // Проверка, существует ли запись в ProjectSupporter для данного проекта и пользователя
        $projectSupporter = $entityManager->getRepository(ProjectSupporter::class)->findOneBy([
            'project' => $project,
            'user' => $user,
        ]);

        if (!$projectSupporter) {
            // Если запись не существует, создаем новую
            $projectSupporter = new ProjectSupporter();
            $projectSupporter->setProject($project);
            $projectSupporter->setUser($user);

            // Сохранение в базе данных
            $entityManager->persist($projectSupporter);
            $entityManager->flush();

            // Увеличиваем счетчик лайков
            $project->incrementLikeCount();
            $entityManager->flush();
             // Возвращение результата в виде JSON
             return new JsonResponse(['message' => 'Лайк успешно добавлен', 'likeCount' => $project->getLikeCount()], Response::HTTP_OK);
            }
    
            // Возвращение результата в виде JSON
            return new JsonResponse(['message' => 'Лайк уже добавлен', 'likeCount' => $project->getLikeCount()], Response::HTTP_CONFLICT);
    }
}