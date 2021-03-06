<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\User;

class UserController extends Controller
{
    public function profileAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('AppBundle:Home:index.html.twig', [
            //'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    public function avataraAction($id) {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);

        return new Response(
            stream_get_contents($user->getAvatara()),
            Response::HTTP_OK,
            array(
                'Content-Type' => 'application/octet-stream'
            )
        );
    }

}
