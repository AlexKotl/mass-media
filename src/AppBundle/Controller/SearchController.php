<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Site;

class SearchController extends Controller
{

    public function searchAction(Request $request)
    {

        $sites = $this->getDoctrine()->getRepository(Site::class)
            ->findBy(
                ['flag' => 1],
                ['url' => 'ASC'],
                50
            );

        return $this->render('AppBundle:Search:index.html.twig', [
            'sites' => $sites,
        ]);
    }

}
