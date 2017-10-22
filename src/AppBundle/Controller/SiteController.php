<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Site;

class SiteController extends Controller
{
    public function detailsAction($url)
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

        return $this->render('AppBundle:Site:details.html.twig', array(
            'site' => $site
        ));
    }

}
