<?php

namespace ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use ApiBundle\Entity\Community;
use Symfony\Component\HttpFoundation\Response;
use ApiBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;

class CommunityController extends Controller
{

    // Liste les communautés
    public function indexAction()
    {
        $repository = $this->getDoctrine()->getRepository('ApiBundle:Community');
        $communitys = $repository->findAll();
        $tableCommunitys = array();

        foreach ($communitys as $community) {
            $tableCommunitys[] = array(
                'id' => $community->getId(),
                'name' => $community->getName(),
                'description' => $community->getDescription(),
            );
        }

        return $this->get('service_data_response')->JsonResponse($tableCommunitys);
    }

    // Ajoute une communauté
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

                        if (!empty(isset($data['name'])) && !empty(isset($data['description']))) {

                            $repository = $em->getRepository('ApiBundle:Community');

                            if (!$community = $repository->findOneBy(array('name' => $data['name']))) {
                                $a = new Community();
                                $a->setName($data['name']);
                                $a->setDescription($data['description']);

                                $em->persist($a);
                                $em->flush();

                                $community = $repository->findOneBy(array('name' => $data['name']));
                                $data = array(
                                    'id' => $community->getId(),
                                    'name' => $community->getName(),
                                    'description' => $community->getDescription(),
                                );
                                return $this->get('service_data_response')->JsonResponse($data);

                            } else {
                                return $this->get('service_errors_messages')->errorMessage("009");
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

    // Supprime une communauté
    public function deleteAction(Request $request, $id)
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

                        if (!empty($id)) {

                            $repository = $em->getRepository('ApiBundle:Community');

                            if ($community = $repository->findOneBy(array('id' => $id))) {

                                $em->remove($community);
                                $em->flush();

                                $data = array(
                                    'message' => "Communauté supprimée.",
                                );
                                return $this->get('service_data_response')->JsonResponse($data);

                            } else {
                                return $this->get('service_errors_messages')->errorMessage("010");
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
}
