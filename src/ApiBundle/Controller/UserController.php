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
        //$users = $repository->findBy(array(), array('name' => 'ASC'),10);
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
        if (!empty($content)) {
            $params = json_decode($content, true);
        }

        $arr = array('name' => $params['name'], 'firstName' => $params['firstName']);
        $reponse = json_encode($arr,JSON_UNESCAPED_UNICODE);

        $object = new JsonResponse($reponse);
        $object->headers->set('Access-Control-Allow-Origin', 'http://localhost:3000');
        $object->headers->set('Access-Control-Allow-Headers', 'Content-Type');
        $object->headers->set('Content-Type', 'application/json; charset=utf-8');

        return $object;
    }

    // Fonction qui authentifie l'utilisateur
    public function loginAction(){

        $params = array();
        $content = $this->get("request")->getContent();
        if (!empty($content)) {
            $params = json_decode($content, true);
        }

        if(!empty($params['login']) && !empty($params['password'])){

            $em = $this->getDoctrine()->getEntityManager();
            $repository = $em->getRepository('ApiBundle:User');
            $user = $repository->findOneBy(array('email' => $params['login']));

            if(password_verify($params['password'], $user->getPassword())){

                try{
                    $token = bin2hex(openssl_random_pseudo_bytes(20));
                    $date = new \DateTime();
                    $date->modify('+1 day');

                    $valideToken = $date->format('Y-m-d H:i:s');

                    $user->setToken($token);
                    $user->setValideToken($date);
                    $em->flush();

                    $arr = array('id' => $user->getId(), 'name' => $user->getName(), 'firstName' => $user->getFirstName(), 'email' => $user->getEmail(),  'token' => $token, 'valideToken' => $valideToken);
                    $reponse = json_encode($arr,JSON_UNESCAPED_UNICODE);

                }
                catch(Exception $ex){
                    throw new Exception("Une erreur interne s'est produite.");
                }
            }
            else{
                throw new Exception("Le login ou le mot de passe est incorrect.");
            }
        }else{
            throw new Exception("Veuillez envoyer le login et le mot de passe.");
        }

        return new JsonResponse($reponse);
    }
}
