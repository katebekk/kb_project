<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Heart;
use App\Form\PostType;
use App\Form\PostEditType;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


/**
 * @Route("/post")
 */
class PostController extends AbstractController
{
    /**
     * @Route("/", name="post_index", methods={"GET"})
     */
    public function index(PostRepository $postRepository): Response
    {
        return $this->render('post/index.html.twig', [
            'posts' => $postRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="post_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $post = new Post();
        $post->setDateOfCreation(new \DateTime());
        $user = $this->getUser();
        $post->setUser($user);
        $user->addPost($post);
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $request->files->get('post')['my_file'];

            $uploads_directory = $this->getParameter('uploads_directory');

            $filename = md5(uniqid()) . '.' . $file->guessExtension();

            $file->move(
              $uploads_directory,
              $filename
            );
            $post->setImg($filename);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($post);
            $entityManager->flush();

            return $this->redirectToRoute('my_posts');
        }

        return $this->render('post/new.html.twig', [
            'post' => $post,
            'form' => $form->createView(),

        ]);
    }

    /**
     * @Route("/{id}", name="post_show", methods={"GET","POST"})
     */
    public function show(Request $request,Post $post): Response
    {   $ref = $_SERVER['HTTP_REFERER'];
        $user=$post->getUser();
        $curUser = $this->getUser();
        $form = $this->createFormBuilder()
            ->getForm();
        $form->handleRequest($request);
        $postHearts = $post->getHearts();
        $isLiked = $post->searchHeart($curUser);

        if ($form->isSubmitted() && $isLiked == false ) {
            $heart = new Heart();
            $heart->setDateHeart(new \DateTime());
            $heart->setUser($curUser);
            $heart->setPost($post);
            $curUser->addHeart($heart);
            $post->addHeart($heart);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($heart);
            $entityManager->flush();
        }

        return $this->render('post/show.html.twig', [
            'post' => $post,
            'user' => $user,
            'ref' => $ref,
            'image' => $post->getImg(),
            'form' => $form->createView(),
            'hearts_numb'=>count($post->getHearts()),

        ]);
    }

    /**
     * @Route("/{id}/edit", name="post_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Post $post): Response
    {
        /*$form = $this->createFormBuilder(PostType::class, $post)
            ->add('description')
            ->add('category', EntityType ::class, [
                'class' => 'App\Entity\Category',
                'label' => 'Категория'
            ])
            ->getForm();*/
        $form = $this->createForm(PostEditType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('my_posts');
        }

        return $this->render('post/edit.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="post_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Post $post): Response
    {
        if ($this->isCsrfTokenValid('delete'.$post->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $like = $post->getHearts();
            $entityManager->remove($post);
            $entityManager->flush();
        }

        return $this->redirectToRoute('my_posts');
    }
    /**
     * @Route("/{id}/by_category", name="by_category", methods={"GET"})
     */
    public function by_category(PostRepository $postRepository, Post $post): Response
    {   $postRep = $postRepository->findAll();
        $category = $post->getCategory();
        $categoryPosts = new ArrayCollection();
        foreach ($postRep as $item)
            if ($item->getCategory() === $category)
                $categoryPosts[] = $item;
        return $this->render('post/by_category.html.twig', [
            'posts' => $categoryPosts,
            'category'=>$category,
        ]);
    }
}
