<?php

namespace App\Controller;

use App\Entity\Like;
use App\Form\PostType;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LikeController extends AbstractController
{
    /**
     * @Route("/like", name="like")
     */
    public function index()
    {
        return $this->render('like/index.html.twig', [
            'controller_name' => 'LikeController',
        ]);
    }
    /**
     * @Route("/add_like", name="add_like", methods={"GET","POST"})
     */
    public function new(Post $post)
    {
        $like = new Like();
        $like->setLakeDate(new \DateTime());
        $user = $this->getUser();
        $like->setUser($user);
        $like->setPost($post);
        $user->addLike($like);
        $post->addLike($like);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($like);
        $entityManager->flush();
        /*$form = $this->createFormBuilder()
            ->add('submit', 'submit', array('label' => 'Like'))
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($post);
            $entityManager->flush();
        }*/
    }
}
