<?php

namespace ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use ApiBundle\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Cette classe permet des gérer les utilisateurs
 */
class UserController extends Controller
{
    /**
     * Ajouter un utilisateur
     * @author Steve Vandycke, Alexandre Chevallier, Charles Grimont, Thibault Tichet
     * @param JSON d'ajout d'un utilisateur
     * @return JSON de réponse d'ajout d'un utilisateur
     */
    public function addAction(Request $request)
    {
        try{
            $em = $this->getDoctrine()->getEntityManager();
            $data = json_decode($request->getContent(), true);
            $repository = $em->getRepository('ApiBundle:User');

            if (!empty(isset($data['name'])) && !empty(isset($data['firstName'])) && !empty(isset($data['email'])) && !empty(isset($data['password']))) {
                if (!$user = $repository->findOneBy(array('email' => $data['email']))) {
                    $a = new User();
                    $a->setFirstName($data['firstName']);
                    $a->setName($data['name']);
                    $a->setEmail($data['email']);
                    $a->setPassword(md5($data['password']));
                    $a->setAdministrator(0);

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
        }catch(Exception $ex) {
            return $this->get('service_errors_messages')->errorMessage("001");
        }
    }

    /**
     * Authentification d'un utilisateur
     * @author Steve Vandycke, Alexandre Chevallier, Charles Grimont, Thibault Tichet
     * @param JSON de connexion utilisateur
     * @return JSON de retour de connexion utilisateur
     */
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

    /**
     * Tester la validité du token
     * @author Steve Vandycke, Alexandre Chevallier, Charles Grimont, Thibault Tichet
     * @param JSON du test de validité de token
     * @return JSON de retour du test de validité de token
     */
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

    /**
     * Lister les utilisateurs d'une communauté
     * @author Steve Vandycke, Alexandre Chevallier, Charles Grimont, Thibault Tichet
     * @param JSON pour lister les utilisateur d'une commuanuté
     * @return JSON de retour d'une liste d'utilisateurs d'une commuanuté
     */
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
