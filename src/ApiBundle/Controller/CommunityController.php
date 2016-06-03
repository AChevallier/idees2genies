<?php

namespace ApiBundle\Controller;

use ApiBundle\Entity\UserCommunity;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use ApiBundle\Entity\Community;
use Symfony\Component\HttpFoundation\Response;
use ApiBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;

/**
 * Cette classe permet la gestion des communautés
 */
class CommunityController extends Controller
{

    /**
     * Lister les communautés
     * @author Steve Vandycke, Alexandre Chevallier, Charles Grimont, Thibault Tichet
     * @param Aucun paramètre (seulement le token dans le header)
     * @return JSON de retourn d'une liste de communauté
     */
    public function indexAction(Request $request)
    {
        try{
            $token = $request->headers->get('token');

            $em = $this->getDoctrine()->getEntityManager();
            $repository = $em->getRepository('ApiBundle:User');

            $user = $repository->findOneBy(array('token' => $token));

            if($user){
                $idUser = $user->getId();
                $valideToken = $user->getValideToken();
                $date = new \DateTime();

                if($valideToken > $date){

                    $qb = $em->createQueryBuilder()
                        ->select('c.id as id, c.name AS nameCommunity, c.description AS descriptionCommunity')
                        ->from('ApiBundle:Community', 'c')
                        ->addOrderBy('c.name', 'ASC');

                        $communities = $qb->getQuery()->getResult();

                    foreach ($communities as $community) {
                        $repository = $this->getDoctrine()->getRepository('ApiBundle:UserCommunity');
                        $joinUser = $repository->findOneBy(array('idUser' => $idUser, 'idCommunity' => $community['id']));

                        if($joinUser){
                            $joinUser = true;
                        }else{
                            $joinUser = false;
                        }

                        $qb = $em->createQueryBuilder()
                            ->select('COUNT(uc.id)')
                            ->from('ApiBundle:UserCommunity', 'uc')
                            ->where('uc.idCommunity = :idCommunity')
                            ->setParameters(array('idCommunity' => $community['id']))
                        ;
                        $nbUsers = $qb->getQuery()->getSingleScalarResult();

                        $tableCommunities[] = array(
                            'id' => $community['id'],
                            'name' => $community['nameCommunity'],
                            'description' => $community['descriptionCommunity'],
                            'joinUser' => $joinUser,
                            'nbUsers' => $nbUsers
                        );
                    }




                        return $this->get('service_data_response')->JsonResponse($tableCommunities);
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

    /**
     * Ajouter une communauté
     * @author Steve Vandycke, Alexandre Chevallier, Charles Grimont, Thibault Tichet
     * @param JSON qui contient les informations de la communauté à ajouter
     * @return JSON de retourn d'un ajout de communauté
     */
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

    /**
     * Supprimer une communauté
     * @author Steve Vandycke, Alexandre Chevallier, Charles Grimont, Thibault Tichet
     * @param Aucun paramètre, ID de la communauté en GET (seulement le token ainsi que l'ID)
     * @return JSON de retour de suppression d'une communauté
     */
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

    /**
     * Récupérer ses communautés
     * @author Steve Vandycke, Alexandre Chevallier, Charles Grimont, Thibault Tichet
     * @param Aucun paramètre, ID de la communauté en GET (seulement le token ainsi que l'ID)
     * @return JSON de retour d'une liste de communautés
     */
    public function myCommunitiesAction(Request $request)
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

                    $qb = $em->createQueryBuilder()
                        ->select('uc.idCommunity AS idCommunity, c.name AS nameCommunity, c.description AS descriptionCommunity')
                        ->from('ApiBundle:UserCommunity', 'uc')
                        ->innerJoin('ApiBundle:User', 'u', 'WITH', 'uc.idUser = u.id')
                        ->innerJoin('ApiBundle:Community', 'c', 'WITH', 'uc.idCommunity = c.id')
                        ->where('u.token = :token')
                        ->setParameters(array('token' => $token))
                        ->addOrderBy('c.name', 'ASC')
                    ;
                    $communities = $qb->getQuery()->getResult();

                    $tableCommunities = array();
                    foreach ($communities as $community) {

                        $qb = $em->createQueryBuilder()
                            ->select('count(uc.id)')
                            ->from('ApiBundle:UserCommunity', 'uc')
                            ->where('uc.idCommunity = :idCommunity')
                            ->setParameters(array('idCommunity' => $community['idCommunity']))
                            ->groupBy('uc.idCommunity')
                        ;
                        $nbUsers = $qb->getQuery()->getSingleScalarResult();

                        $qb = $em->createQueryBuilder()
                            ->select('count(i.idCommunauty) AS nbIdeas')
                            ->from('ApiBundle:Idea', 'i')
                            ->where('i.idCommunauty = :idCommunity')
                            ->setParameters(array('idCommunity' => $community['idCommunity']))
                            ->groupBy('i.idCommunauty')
                        ;

                        $nbIdeas = $qb->getQuery()->getOneOrNullResult();

                        if($nbIdeas['nbIdeas'] == null){
                            $nbIdeas = '0';
                        }else{
                            $nbIdeas = $nbIdeas['nbIdeas'];
                        }

                        $tableCommunities[] = array('idCommunity' => $community['idCommunity'],
                            'idCommunity' => $community['idCommunity'],
                            'nameCommunity' => $community['nameCommunity'],
                            'descriptionCommunity' => $community['descriptionCommunity'],
                            'nbUsers' => $nbUsers,
                            'nbIdeas' => $nbIdeas,
                        );
                    }

                    return $this->get('service_data_response')->JsonResponse($tableCommunities);


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

    /**
     * Récupérer la liste des communautés d'un utilisateur
     * @author Steve Vandycke, Alexandre Chevallier, Charles Grimont, Thibault Tichet
     * @param Aucun paramètre, ID de l'utilisateur en GET
     * @return JSON de retour d'une liste de communautés
     */
    public function userCommunitiesAction(Request $request, $id)
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

                        if (!empty(isset($id))){

                            if($user = $repository->findOneBy(array('id' => $id))) {

                                $qb = $em->createQueryBuilder()
                                    ->select('uc.idCommunity AS idCommunity, c.name AS nameCommunity, c.description AS descriptionCommunity')
                                    ->from('ApiBundle:UserCommunity', 'uc')
                                    ->innerJoin('ApiBundle:User', 'u', 'WITH', 'uc.idUser = u.id')
                                    ->innerJoin('ApiBundle:Community', 'c', 'WITH', 'uc.idCommunity = c.id')
                                    ->where('u.id = :id')
                                    ->setParameters(array('id' => $id))
                                    ->addOrderBy('c.name', 'ASC')
                                    ;
                                $data = $qb->getQuery()->getResult();

                                return $this->get('service_data_response')->JsonResponse($data);
                            }
                            else{
                                return $this->get('service_errors_messages')->errorMessage("008");
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

    /**
     * Adhérer / annuler adhésion à une communauté
     * @author Steve Vandycke, Alexandre Chevallier, Charles Grimont, Thibault Tichet
     * @param JSON d'adhésion/annulation à une communauté
     * @return JSON de retour d'adhésion ou d'annulation d'adhésion à une communauté
     */
    public function joinAction(Request $request)
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

                    $data = json_decode($request->getContent(), true);

                    $repository = $em->getRepository('ApiBundle:Community');

                    if(isset($data['id'])){
                        if($idea = $repository->findOneBy(array('id' => $data['id']))) {

                            $repository = $em->getRepository('ApiBundle:UserCommunity');

                            if($joinUserCommunity = $repository->findOneBy(array('idUser' => $user->getId(), 'idCommunity' => $data['id']))){

                                $em->remove($joinUserCommunity);
                                $em->flush();

                                $data = array(
                                    'join' => false,
                                );

                                return $this->get('service_data_response')->JsonResponse($data);
                            }else{

                                $joinUserCommunity = new UserCommunity();

                                $joinUserCommunity->setIdCommunity($data['id']);
                                $joinUserCommunity->setIdUser($user->getId());

                                $em->persist($joinUserCommunity);
                                $em->flush();

                                $data = array(
                                    'join' => true,
                                );

                                return $this->get('service_data_response')->JsonResponse($data);
                            }

                        }else{
                            return $this->get('service_errors_messages')->errorMessage("011");
                        }
                    }
                    else{
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

    /**
     * Récupérer les informations d'une communauté
     * @author Steve Vandycke, Alexandre Chevallier, Charles Grimont, Thibault Tichet
     * @param JSON de récupération d'information d'une communauté
     * @return JSON de retour d'informations d'une communauté
     */
    public function getCommunityAction(Request $request)
    {
        try{
            $token = $request->headers->get('token');

            $em = $this->getDoctrine()->getEntityManager();
            $repository = $em->getRepository('ApiBundle:User');

            $user = $repository->findOneBy(array('token' => $token));

            if($user){
                $idUser = $user->getId();
                $valideToken = $user->getValideToken();
                $date = new \DateTime();

                if($valideToken > $date){

                    $data = json_decode($request->getContent(), true);
                    $repository = $em->getRepository('ApiBundle:Community');

                    if(!empty($data['id']) && isset($data['id'])){

                        $repository = $em->getRepository('ApiBundle:Community');

                        if($community = $repository->findOneBy(array('id' => $data['id']))) {


                            $qb = $em->createQueryBuilder()
                                ->select('c.id AS id, c.name AS name, c.description AS description')
                                ->from('ApiBundle:Community', 'c')
                                ->where('c.id = :id')
                                ->setParameters(array('id' => $data['id']))
                            ;
                            $community = $qb->getQuery()->getOneOrNullResult();

                            $qb = $em->createQueryBuilder()
                                ->select('count(uc.id) AS nbUsers ')
                                ->from('ApiBundle:UserCommunity', 'uc')
                                ->where('uc.idCommunity = :idCommunity')
                                ->setParameters(array('idCommunity' => $data['id']))
                                ->groupBy('uc.idCommunity')
                            ;
                            $nbUsers = $qb->getQuery()->getOneOrNullResult();

                            if($nbUsers == null){
                                $nbUsers = '0';
                            }else{
                                $nbUsers = $nbUsers['nbUsers'];
                            }

                            $repository = $this->getDoctrine()->getRepository('ApiBundle:UserCommunity');
                            $joinUser = $repository->findOneBy(array('idUser' => $idUser, 'idCommunity' => $community['id']));

                            if($joinUser){
                                $joinUser = true;
                            }else{
                                $joinUser = false;
                            }


                            $data = array(
                                'id' => $community['id'],
                                'name' => $community['name'],
                                'description' => $community['description'],
                                'nbUsers' => $nbUsers,
                                'joinUser' => $joinUser,
                            );

                            return $this->get('service_data_response')->JsonResponse($data);
                        }
                        else{
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
