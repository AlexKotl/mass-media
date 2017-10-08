<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FacebookController extends Controller
{
    public function connectAction()
    {
        return $this->get('oauth2.registry')
            ->getClient('facebook_main')
            ->redirect();
    }

    public function connectCheckAction()
    {
        return $this->render('AppBundle:Facebook:connect_check.html.twig', array(
            // ...
        ));
    }

}
