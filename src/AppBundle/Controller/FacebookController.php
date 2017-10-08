<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FacebookController extends Controller
{
    public function connectAction()
    {
        return $this->render('AppBundle:Facebook:connect.html.twig', array(
            // ...
        ));
    }

    public function connectCheckAction()
    {
        return $this->render('AppBundle:Facebook:connect_check.html.twig', array(
            // ...
        ));
    }

}
