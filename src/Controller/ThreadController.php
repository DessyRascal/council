<?php

namespace App\Controller;

use App\Entity\Thread;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ThreadController extends AbstractController
{
    /**
     * @Route("/threads", name="threads_index", methods={"GET"})
     * @param EntityManagerInterface $em
     *
     * @return Response
     */
    public function index(EntityManagerInterface $em): Response
    {
        $threads = $em->getRepository(Thread::class)->findAll();

        return $this->render('thread/index.html.twig', [
            'threads' => $threads
        ]);
    }

    /**
     * @Route("/threads/{id}", name="threads_show", methods={"GET"})
     * @param Thread $thread
     *
     * @return Response
     */
    public function show(Thread $thread): Response
    {
        return $this->render('thread/show.html.twig', [
            'thread' => $thread
        ]);
    }
}
