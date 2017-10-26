<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Site;
use AppBundle\Entity\Comment;
use AppBundle\Form\CommentType;

class SiteController extends Controller
{
    public function detailsAction($url, Request $request)
    {
        $result = $this->getDoctrine()->getRepository(Site::class)
            ->findBy(['url' => $url]);

        if (count($result) === 0) {
            throw $this->createNotFoundException('The site is not exist in database');
        }

        $site = $result[0];

        if ($site->getFlag() !== 1) {
            throw $this->createNotFoundException('The site is blocked');
        }

        // comment form
        $comment = new Comment;
        $commentForm = $this->createForm(CommentType::class, $comment);
        $commentForm->handleRequest($request);

        if ($commentForm->isSubmitted() && $commentForm->isValid())
        {
            $comment
                ->setDateCreated(new \DateTime("now"))
                //->setUser($post->getUser())
                ->setSite($site);

            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();
        }

        return $this->render('AppBundle:Site:details.html.twig', array(
            'site' => $site,
            'comment_form' => $commentForm->createView(),
        ));
    }

}
