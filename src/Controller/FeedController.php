<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FeedController extends AbstractController
{
    private $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * @Route("/feed", name="feed")
     */
    public function index(): Response
    {
        $user = $this->getUser();
        $subscriptions = $user->getSubscriptions();
        $feedPosts = array();
        foreach ($subscriptions as $subscription) {

            $posts = $this->postRepository->findBy(['user' => $subscription]);
            foreach ($posts as $post) {
                $feedPosts[] = $post;
            }
        }

        usort($feedPosts, function ($a, $b) {
            $dmyA = $a->getDateOfCreation()->format('d-m-Y');
            $dmyB = $b->getDateOfCreation()->format('d-m-Y');
            return strtotime($dmyB) - strtotime($dmyA);
        });

        return $this->render('feed/index.html.twig', [
            'feedPosts' => $feedPosts
        ]);
    }
}
