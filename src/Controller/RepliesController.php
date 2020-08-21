<?php

namespace App\Controller;

use App\Entity\Reply;
use App\Entity\Thread;
use App\Repository\ReplyRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RepliesController extends AbstractController
{
    /**
     * @Route("/threads/{id}/replies", name="replies_add", methods={"POST"})
     * @IsGranted("ROLE_USER")
     * @param Request $request
     * @param Thread $thread
     *
     * @return RedirectResponse
     */
    public function store(Request $request, Thread $thread): RedirectResponse
    {
        $body = $request->request->get('body', null);

        $reply = new Reply();
        $reply->setBody($body);
        $reply->setOwner($this->getUser());
        $reply->setThread($thread);

        $em = $this->getDoctrine()->getManager();
        $em->persist($reply);
        $em->flush();

        return $this->redirectToRoute('threads_show', ['id' => $thread->getId()]);
    }
}
