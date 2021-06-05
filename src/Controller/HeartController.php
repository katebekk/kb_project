<?php

namespace App\Controller;

use App\Entity\Heart;
use App\Form\HeartType;
use App\Repository\HeartRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/heart")
 */
class HeartController extends AbstractController
{
    /**
     * @Route("/", name="heart_index", methods={"GET"})
     */
    public function index(HeartRepository $heartRepository): Response
    {
        return $this->render('heart/index.html.twig', [
            'hearts' => $heartRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="heart_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $heart = new Heart();
        $form = $this->createForm(HeartType::class, $heart);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($heart);
            $entityManager->flush();

            return $this->redirectToRoute('heart_index');
        }

        return $this->render('heart/new.html.twig', [
            'heart' => $heart,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="heart_show", methods={"GET"})
     */
    public function show(Heart $heart): Response
    {
        return $this->render('heart/show.html.twig', [
            'heart' => $heart,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="heart_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Heart $heart): Response
    {
        $form = $this->createForm(HeartType::class, $heart);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('heart_index');
        }

        return $this->render('heart/edit.html.twig', [
            'heart' => $heart,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="heart_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Heart $heart): Response
    {
        if ($this->isCsrfTokenValid('delete'.$heart->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($heart);
            $entityManager->flush();
        }

        return $this->redirectToRoute('heart_index');
    }
}
