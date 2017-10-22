<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SiteController extends Controller
{
    public function detailsAction()
    {
        return $this->render('AppBundle:Site:details.html.twig', array(
            // ...
        ));
    }

}
