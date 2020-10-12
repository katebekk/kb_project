<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\Form\Forms;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user", methods={"GET"})
     */
    public function index(UserRepository $userRepository)
    {
        return $this->render('main/index.html.twig', [
            'user' => $userRepository->findAll(),
        ]);
    }
    /**
     * @Route("/show", name="my_posts", methods={"GET"})
     */
    public function my_photo(): Response
    {
        $user = $this->getUser();
        return $this->render('user/my_posts.html.twig', [
            'posts' => $user->getPost(),
        ]);
    }
    /**
     * @Route("/all_users", name="all_users", methods={"GET"})
     */
    public function allUsers(UserRepository $userRepository): Response
    {   $curUser = $this->getUser();
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
            'curUser'=>$curUser,
        ]);
    }
    /**
     * @Route("/subscriptions", name="my_subscriptions", methods={"GET"})
     */
    public function mySubscriptions(UserRepository $userRepository): Response
    {   $curUser = $this->getUser();
        return $this->render('user/my_subscr.html.twig', [
            'users' => $curUser->getSubscriptions(),
            'name'=>'Мои подписки',
        ]);
    }
    /**
     * @Route("/subscribers", name="my_subscribers", methods={"GET"})
     */
    public function mySubscribers(UserRepository $userRepository): Response
    {   $curUser = $this->getUser();
        return $this->render('user/my_subscr.html.twig', [
            'users' => $curUser->getSubscribers(),
            'name'=>'Мои подписчики',
        ]);
    }
    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user): Response
    {
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/{id}", name="user_show", methods={"GET","POST"})
     */
    public function show(Request $request,User $user): Response
    {
        $curUser = $this->getUser();
        $form = $this->createFormBuilder()
            ->getForm();
        $form->handleRequest($request);
        $isSubscr = $curUser->isSubscribed($user);

        if ($form->isSubmitted() && $isSubscr==false) {
            $entityManager = $this->getDoctrine()->getManager();
            $user->addSubscriber($curUser);
            $curUser->addSubscription($user);
            $entityManager->flush();
        }
        else if ($form->isSubmitted() && $isSubscr==true){
            $entityManager = $this->getDoctrine()->getManager();
            $curUser->removeSubscription($user);
            $user->removeSubscriber($curUser);
            $entityManager->flush();
        }
        return $this->render('user/show.html.twig', [
            'user' => $user,
            'posts' => $user->getPost(),
            'form' => $form->createView(),
        ]);
    }

}
