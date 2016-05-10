<?php

namespace ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use ApiBundle\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    public function indexAction()
    {
        $repository = $this->getDoctrine()->getRepository('ApiBundle:User');
        $users = $repository->findAll();
        $tableUsers = array();

    	foreach ($users as $user) {
            $tableUsers[] = array(
        		'id' => $user->getId(),
            	'name' => $user->getName(),
            	'firstName' => $user->getFirstName(),
        	);
    	}

        $reponse = new JsonResponse($tableUsers);
        $reponse->headers->set('Access-Control-Allow-Origin', 'http://localhost:3000');

        return $reponse;
    }

    public function addAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $a = new User();
        $a->setFirstName("Marie");
        $a->setName("GEFFLOT");

        $em->persist($a);
        $em->flush();

        return new Response("Utilisateur ajouté");

    }

    public function postAction(Request $request){

        $name = $request->request->get('name');
        //$firstName = $request->request->get('firstName');
        //$header = $request->headers->get('APIkey');

        //$valeur = $firstName." ".$name." ".$header;

        $reponse = new Response($name);
        $reponse->headers->set('Access-Control-Allow-Origin', 'http://localhost:3000');

        return $reponse;
    }

    public function getAction($name){



        return new Response($name);
    }
}
