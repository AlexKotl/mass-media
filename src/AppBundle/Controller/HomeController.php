<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Site;
use AppBundle\Entity\Comment;

class HomeController extends Controller
{

    public function indexAction(Request $request)
    {
        $comments = $this->getDoctrine()->getRepository(Comment::class)
            ->findLatest(5);

        $sites = $this->getDoctrine()->getRepository(Site::class)
            ->findBy(
                ['flag' => 1],
                ['url' => 'ASC'],
                50
            );

        return $this->render('AppBundle:Home:index.html.twig', [
            'comments' => $comments,
            'sites' => $sites,
        ]);
    }

}
