<?php
// src/Form/ForumCommentType.php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\Event\SubmitEvent;
use App\Entity\ForumComment;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\ForumPost;
use App\Entity\User;

class ForumCommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('text', TextareaType::class, [
                'label' => 'Votre Commentaire',
            ])
            ->add('user', HiddenType::class, [
                'data' => $options['user'] ? $options['user']->getId() : null,
                'attr' => ['readonly' => true],
                'mapped' => false, // Игнорировать при обработке формы
            ])
            ->add('post', HiddenType::class, [
                'data' => $options['post'] ? $options['post']->getId() : null,
                'attr' => ['readonly' => true],
                'mapped' => false, // Игнорировать при обработке формы
            ])
         ;

        $builder->addEventListener(FormEvents::SUBMIT, function (SubmitEvent $event) use ($options) {
            $form = $event->getForm();
            $user = $options['user'];
            $post = $options['post'];

            if ($user && $post) {
                $event->getData()->setUser($user);
                $event->getData()->setPost($post);
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ForumComment::class,
            'user' => null,
            'post' => null,
        ]);

        $resolver->setDefined(['user', 'post']);
    }
}
