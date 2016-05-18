<?php

namespace ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use ApiBundle\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class UserController extends Controller
{

    // Fonction homePage de user
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
                'email' => $user->getEmail(),
                'administrator' => $user->getAdministrator(),
        	);
    	}

        $reponse = json_encode($tableUsers,JSON_UNESCAPED_UNICODE);

        $reponse = new Response($reponse);
        $reponse->headers->set('Access-Control-Allow-Origin', 'http://localhost:3000');

        return $reponse;
    }

    // Fonction qui ajoute un utilisateur
    public function addAction(Request $request)
    {
        try{
            $token = $request->headers->get('token');

            $em = $this->getDoctrine()->getEntityManager();
            $repository = $em->getRepository('ApiBundle:User');

            $user = $repository->findOneBy(array('token' => $token));

            if($user){
                $valideToken = $user->getValideToken();
                $date = new \DateTime();

                if($valideToken > $date){
                    if($user->getAdministrator() == true) {
                        $data = json_decode($request->getContent(), true);

                        if (!empty(isset($data['name'])) && !empty(isset($data['firstName'])) && !empty(isset($data['email'])) && !empty(isset($data['password'])) && ($data['administrator'] == "1" || $data['administrator'] == "0") && isset($data['administrator'])) {
                            if (!$user = $repository->findOneBy(array('email' => $data['email']))) {
                                $a = new User();
                                $a->setFirstName($data['firstName']);
                                $a->setName($data['name']);
                                $a->setEmail($data['email']);
                                $a->setPassword(password_hash($data['password'], PASSWORD_BCRYPT));
                                $a->setAdministrator($data['administrator']);

                                $em->persist($a);
                                $em->flush();

                                $user = $repository->findOneBy(array('email' => $data['email']));
                                $arr = array('id' => $user->getId(), 'name' => $user->getName(), 'firstName' => $user->getFirstName(), 'email' => $user->getEmail());
                                $reponse = json_encode($arr,JSON_UNESCAPED_UNICODE);
                                return new JsonResponse($reponse, 200);

                            } else {
                                return $this->get('service_errors_messages')->errorMessage("006");
                            }
                        } else {
                            return $this->get('service_errors_messages')->errorMessage("002");
                        }
                    }
                    else{
                        return $this->get('service_errors_messages')->errorMessage("007");
                    }
                }else{
                    return $this->get('service_errors_messages')->errorMessage("005");
                }
            }else{
                return $this->get('service_errors_messages')->errorMessage("004");
            }
        }catch(Exception $ex) {
            return $this->get('service_errors_messages')->errorMessage("001");
        }
    }

    // Fonction qui authentifie l'utilisateur
    public function loginAction(){

        try{
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
                        return new JsonResponse($reponse, 200);

                    }
                    catch(Exception $ex){
                        return $this->get('service_errors_messages')->errorMessage("001");
                    }
                }
                else{
                    return $this->get('service_errors_messages')->errorMessage("003");
                }
            }else{
                return $this->get('service_errors_messages')->errorMessage("002");
            }
        }catch(Exception $ex){
            return $this->get('service_errors_messages')->errorMessage("001");
        }
    }
}
