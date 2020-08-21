<?php

namespace App\Controller;

use App\Entity\Reply;
use App\Entity\Thread;
use App\Form\ReplyType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("/threads/{id}", name="threads_show", methods={"GET", "POST"})
     * @param Request $request
     * @param Thread $thread
     *
     * @return Response
     */
    public function show(Request $request, Thread $thread): Response
    {
        $reply = new Reply();

        $form = $this->createForm(ReplyType::class, $reply);
        $form->handleRequest($request);

        if ($request->isMethod('POST')) {
            $this->denyAccessUnlessGranted('ROLE_USER');

            if ($form->isSubmitted() && $form->isValid()) {
                $reply->setOwner($this->getUser());
                $reply->setThread($thread);

                $em = $this->getDoctrine()->getManager();
                $em->persist($reply);
                $em->flush();

                return $this->redirectToRoute('threads_show', [
                    'id' => $thread->getId()
                ]);
            }
        }

        return $this->render('thread/show.html.twig', [
            'thread' => $thread,
            'form' => $form->createView()
        ]);
    }
}
