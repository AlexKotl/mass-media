<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Site;
//use AppBundle\Repository\SearchRepository;

class SearchController extends Controller
{

    public function searchAction(Request $request)
    {

        $sites = $this->getDoctrine()->getRepository(Site::class)
            ->findSitesByKeywords($request->query->get('text'));

        return $this->render('AppBundle:Search:index.html.twig', [
            'sites' => $sites,
        ]);
    }

}
