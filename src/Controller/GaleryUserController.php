<?php

namespace App\Controller;

use App\Entity\GaleryUser;
use App\Form\GaleryUserType;
use App\Repository\GaleryUserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/galery/user")
 */
class GaleryUserController extends AbstractController
{
    /**
     * @Route("/", name="galery_user_index", methods={"GET"})
     */
    public function index(GaleryUserRepository $galeryUserRepository): Response
    {
        return $this->render('galery_user/index.html.twig', [
            'galery_users' => $galeryUserRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="galery_user_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $galeryUser = new GaleryUser();
        $form = $this->createForm(GaleryUserType::class, $galeryUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($galeryUser);
            $entityManager->flush();

            return $this->redirectToRoute('galery_user_index');
        }

        return $this->render('galery_user/new.html.twig', [
            'galery_user' => $galeryUser,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="galery_user_show", methods={"GET"})
     */
    public function show(GaleryUser $galeryUser): Response
    {
        return $this->render('galery_user/my_posts.html.twig', [
            'galery_user' => $galeryUser,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="galery_user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, GaleryUser $galeryUser): Response
    {
        $form = $this->createForm(GaleryUserType::class, $galeryUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('galery_user_index');
        }

        return $this->render('galery_user/edit.html.twig', [
            'galery_user' => $galeryUser,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="galery_user_delete", methods={"DELETE"})
     */
    public function delete(Request $request, GaleryUser $galeryUser): Response
    {
        if ($this->isCsrfTokenValid('delete'.$galeryUser->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($galeryUser);
            $entityManager->flush();
        }

        return $this->redirectToRoute('galery_user_index');
    }
}
