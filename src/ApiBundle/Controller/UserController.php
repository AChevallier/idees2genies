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

        $params = array();
        $content = $this->get("request")->getContent();
        if (!empty($content))
        {
            $params = json_decode($content, true); // 2nd param to get as array
        }

        $reponse = new JsonResponse();
        $reponse -> setData(array(
            'name' => $params['name'],
        ));
        $reponse->headers->set('Access-Control-Allow-Origin', 'http://localhost:3000');
        $reponse->headers->set('Access-Control-Allow-Headers', 'Content-Type');

        return $reponse;
    }

    public function getAction($name){



        return new Response($name);
    }
}
