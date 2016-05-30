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

        return $this->get('service_data_response')->JsonResponse($tableUsers);
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
                                $a->setPassword(md5($data['password']));
                                $a->setAdministrator($data['administrator']);

                                $em->persist($a);
                                $em->flush();

                                $user = $repository->findOneBy(array('email' => $data['email']));
                                $data = array(
                                    'id' => $user->getId(),
                                    'name' => $user->getName(),
                                    'firstName' => $user->getFirstName(),
                                    'email' => $user->getEmail()
                                );
                                return $this->get('service_data_response')->JsonResponse($data);

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

                if($user){
                    if(md5($params['password']) ==  $user->getPassword()){

                        try{
                            $token = bin2hex(openssl_random_pseudo_bytes(20));
                            $date = new \DateTime();
                            $date->modify('+1 day');

                            $valideToken = $date->format('Y-m-d H:i:s');

                            $user->setToken($token);
                            $user->setValideToken($date);
                            $em->flush();

                            $data = array(
                                'id' => $user->getId(),
                                'name' => $user->getName(),
                                'firstName' => $user->getFirstName(),
                                'email' => $user->getEmail(),
                                'token' => $token,
                                'administrator' => $user->getAdministrator(),
                            );

                            return $this->get('service_data_response')->JsonResponse($data);
                        }
                        catch(Exception $ex){
                            return $this->get('service_errors_messages')->errorMessage("001");
                        }
                    }
                    else{
                        return $this->get('service_errors_messages')->errorMessage("003");
                    }
                }else{
                    return $this->get('service_errors_messages')->errorMessage("008");
                }
            }else{
                return $this->get('service_errors_messages')->errorMessage("002");
            }
        }catch(Exception $ex){
            return $this->get('service_errors_messages')->errorMessage("001");
        }
    }

    // Fonction qui teste la valididé du token
    public function isValideTokenAction(){
        try{
            $params = array();
            $content = $this->get("request")->getContent();
            if (!empty($content)) {
                $params = json_decode($content, true);
            }

            if(!empty($params['token'])){

                $em = $this->getDoctrine()->getEntityManager();
                $repository = $em->getRepository('ApiBundle:User');

                $user = $repository->findOneBy(array('token' => $params['token']));

                if($user){
                    $valideToken = $user->getValideToken();
                    $date = new \DateTime();

                    if($valideToken > $date) {
                        $data = array(
                            'valide' => true,
                            'name' => $user->getName(),
                            'firstName' => $user->getFirstName(),
                        );
                        return $this->get('service_data_response')->JsonResponse($data);
                    }else{
                        $data = array(
                            'valide' => false,
                        );
                        return $this->get('service_data_response')->JsonResponse($data);
                    }
                }else{
                    $data = array(
                        'valide' => false,
                    );
                    return $this->get('service_data_response')->JsonResponse($data);
                }
            }else{
                return $this->get('service_errors_messages')->errorMessage("002");
            }
        }catch(Exception $ex){
            return $this->get('service_errors_messages')->errorMessage("001");
        }
    }

    // Fonction qui liste les utilisateurrs d'une communauté
    public function usersCommunityAction(Request $request)
    {
        try{
            $token = $request->headers->get('token');

            $em = $this->getDoctrine()->getEntityManager();
            $repository = $em->getRepository('ApiBundle:User');

            $user = $repository->findOneBy(array('token' => $token));

            if($user){
                $valideToken = $user->getValideToken();
                $idUser = $user->getId();
                $date = new \DateTime();

                if($valideToken > $date){

                    $data = json_decode($request->getContent(), true);

                    if(!empty($data['id']) && isset($data['id'])) {

                        $repository = $em->getRepository('ApiBundle:Community');

                        if($community = $repository->findOneBy(array('id' => $data['id']))) {

                            $qb = $em->createQueryBuilder()
                                ->select('u.id AS idUser, u.name AS nameUser, u.firstName AS firstNameUser')
                                ->from('ApiBundle:UserCommunity', 'uc')
                                ->innerJoin('ApiBundle:User', 'u', 'WITH', 'u.id = uc.idUser')
                                ->where('uc.idCommunity = :idCommunity')
                                ->addOrderBy('nameUser', 'ASC')
                                ->addOrderBy('firstNameUser', 'ASC')
                                ->setParameters(array('idCommunity' => $data['id']))
                            ;

                            $data = $qb->getQuery()->getResult();

                            return $this->get('service_data_response')->JsonResponse($data);
                        }else{
                            return $this->get('service_errors_messages')->errorMessage("010");
                        }
                    }else{
                        return $this->get('service_errors_messages')->errorMessage("002");
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
}
