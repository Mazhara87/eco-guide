<?php

namespace App\Controller;

use App\Entity\ForumPost;
use App\Form\CommentType;
use App\Entity\ForumComment;
use App\Form\ForumPostType;
use App\Form\ForumCommentType;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class CommunityController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/communaute', name: 'app_community')]
    public function index(): Response
    {
        $posts = $this->entityManager->getRepository(ForumPost::class)->findAll();

        return $this->render('community/index.html.twig', [
            'posts' => $posts,
        ]);
    }

   // ...

/**
 * @Route("/create-comment/{id}", name="app_forum_create_comment")
 */
public function createComment(Request $request, ForumPost $post): Response
{
    $comment = new ForumComment();
    $user = $this->getUser();

    if ($user && $post) {
        $comment->setUser($user);
        $comment->setPost($post);
        $comment->setCreatedAt(new \DateTimeImmutable());

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setText($form->get('content')->getData());

            // Убедитесь, что связи устанавливаются корректно
            $comment->setUserId($user->getId());
            $comment->setPostId($post->getId());

            $entityManager = $this->entityManager; // Добавлено
            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('app_forum_show_post_details', ['id' => $post->getId()]);
        }
    }

    return $this->render('community/show_post_details.html.twig', [
        'form' => $form->createView(),
        'post' => $post,
    ]);
}


 
#[Route('/create-post', name: 'create_post')]
public function createPost(Request $request, EntityManagerInterface $entityManager): Response
{
    $form = $this->createForm(ForumPostType::class);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // Création d'une nouvelle instance de ForumPost
        $forumPost = new ForumPost();

        // Attribution des valeurs du formulaire à l'entité
        $forumPost->setTitle($form->get('title')->getData());
        $forumPost->setText($form->get('text')->getData());
        $forumPost->setSummary($form->get('summary')->getData());

        // Obtention de l'utilisateur actuel (supposons que votre entité ForumPost a une relation avec User)
        $user = $this->getUser();
        $forumPost->setUser($user);

        // Définition de la date de création
        $forumPost->setCreatedAt(new \DateTimeImmutable());

        // Utilisation de la variable $entityManager
        $entityManager->persist($forumPost);
        $entityManager->flush();

        return $this->redirectToRoute('app_community');
    }

    return $this->render('community/create_post.html.twig', [
        'form' => $form->createView(),
    ]);
}

/**
 * @Route("/show-post/{id}", name="app_forum_show_post_details")
 */
public function showPostDetails(ForumPost $post, Request $request): Response
{
    $comments = $post->getComments();

    $comment = new ForumComment();
    $comment->setUser($this->getUser());
    $comment->setCreatedAt(new \DateTimeImmutable());

    $form = $this->createForm(ForumCommentType::class, $comment, [
        'user' => $this->getUser(),
        'post' => $post,
    ]);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $comment->setPost($post); // Устанавливаем post перед сохранением

        $entityManager = $this->entityManager;
        $entityManager->persist($comment);
        $entityManager->flush();

        // Обновляем комментарии после добавления нового комментария
        $comments = $post->getComments();
    }

    return $this->render('community/show_post_details.html.twig', [
        'post' => $post,
        'comments' => $comments,
        'commentForm' => $form->createView(),
    ]);
}

/**
 * @Route("/show-post{id}", name="app_forum_show_comment_details")
 */
/*public function showCommentDetails(ForumComment $comment,ForumPost $post, Request $request): Response
{
    $post = $comment->getPost();
    $comments = $post->getComments();

    return $this->render('community/show_post_details.html.twig', [
        'post' => $post,
        'comments' => $comments,
        'commentForm' => null, // Мы не будем передавать форму в этом методе
    ]);
}*/


}
