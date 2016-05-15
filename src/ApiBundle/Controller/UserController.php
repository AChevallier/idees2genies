<?php

namespace ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use ApiBundle\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class UserController extends Controller
{

    // Fonction homePage
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

    // Fonction qui ajoute un utilisateur
    public function addAction(Request $request)
    {
        $token = $request->headers->get('token');

        $em = $this->getDoctrine()->getEntityManager();
        $repository = $em->getRepository('ApiBundle:User');
        $user = $repository->findOneBy(array('token' => $token));

        if($user && $user->getAdministrator() == true){
            $data = json_decode($request->getContent(), true);

            if(!empty(isset($data['name'])) && !empty(isset($data['firstName'])) && !empty(isset($data['email'])) && !empty(isset($data['password'])) && ($data['administrator'] == "1" || $data['administrator'] == "0") && isset($data['administrator'])){
                if(!$user = $repository->findOneBy(array('email' => $data['email']))){
                    $a = new User();
                    $a->setFirstName($data['firstName']);
                    $a->setName($data['name']);
                    $a->setEmail($data['email']);
                    $a->setPassword(password_hash($data['password'],PASSWORD_BCRYPT));
                    $a->setAdministrator($data['administrator']);

                    $em->persist($a);
                    $em->flush();

                    $user = $repository->findOneBy(array('email' => $data['email']));
                    $arr = array('id' => $user->getId(), 'name' => $user->getName(), 'firstName' => $user->getFirstName(), 'email' => $user->getEmail());
                    $reponse = json_encode($arr,JSON_UNESCAPED_UNICODE);

                    $message = "L'utilisateur a été créé.";
                }else{
                    throw new NotFoundHttpException('L\'utilisateur existe déjà.');
                }
            }else{
                throw new NotFoundHttpException('Paramètre(s) manquant(s).');
            }

        }else{
            throw new NotFoundHttpException('Vous n\'avez pas l\'autorisation nécessaire.');
        }
        return new JsonResponse($reponse);
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
                    throw new NotFoundHttpException('Une erreur interne s\'est produite.');
                }
            }
            else{
                throw new NotFoundHttpException('Le login ou le mot de passe est incorrect.');
            }
        }else{
            throw new NotFoundHttpException('Veuillez renseigner le login et le mot de passe.');
        }
        return new JsonResponse($reponse);
    }
}
