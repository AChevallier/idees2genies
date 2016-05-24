<?php

namespace ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use ApiBundle\Entity\User;
use ApiBundle\Entity\Idea;
use ApiBundle\Entity\VoteUserIdea;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


class IdeaController extends Controller
{

    // Fonction qui liste toutes les idées
    public function indexAction(Request $request)
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

                    $em = $this->getDoctrine()->getEntityManager();

                    $repository = $em->getRepository('ApiBundle:Idea');
                    $ideas = $repository->findBy(array(), array('publicateDate' => 'DESC'));

                    $tableIdeas = array();

                    foreach ($ideas as $idea) {

                        $repository = $this->getDoctrine()->getRepository('ApiBundle:VoteUserIdea');
                        $voteUser = $repository->findOneBy(array('idUser' => $idUser, 'idIdea' => $idea->getId()));

                        if($voteUser){
                            $voteUser = true;
                        }else{
                            $voteUser = false;
                        }

                        $repository = $this->getDoctrine()->getRepository('ApiBundle:User');
                        $auteur = $repository->findOneBy(array('id' => $idea->getIdUser()));

                        $qb = $em->createQueryBuilder()
                            ->select('COUNT(vui.id)')
                            ->from('ApiBundle:VoteUserIdea', 'vui')
                            ->where('vui.idIdea = :idIdea')
                            ->setParameters(array('idIdea' => $idea->getId()))
                        ;
                        $nbVotes = $qb->getQuery()->getSingleScalarResult();

                        $dateCreate = $idea->getPublicateDate();
                        $date = $dateCreate->format('d/m/Y  H:i');

                        $tableIdeas[] = array(
                            'id' => $idea->getId(),
                            'title' => $idea->getTitle(),
                            'idea' => $idea->getIdea(),
                            'auteur' => $auteur->getFirstName().' '.$auteur->getName(),
                            'date' => $date,
                            'voteUser' => $voteUser,
                            'nbVotes' => $nbVotes
                        );
                    }
                    return $this->get('service_data_response')->JsonResponse($tableIdeas);

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

    // Fonction qui liste le top 5
    public function top5Action(Request $request)
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

                    $em = $this->getDoctrine()->getEntityManager();

                    $qb = $em->createQueryBuilder()
                        ->select('vui.idIdea AS idIdea, i.title AS title, u.name AS nameAutor, u.firstName AS firstNameAutor, i.publicateDate AS publicateDate, count(vui.id) AS nbVote')
                        ->from('ApiBundle:VoteUserIdea', 'vui')
                        ->innerJoin('ApiBundle:Idea', 'i', 'WITH', 'i.id = vui.idIdea')
                        ->innerJoin('ApiBundle:User', 'u', 'WITH', 'i.idUser = u.id')
                        ->groupBy('vui.idIdea')
                        ->addOrderBy('nbVote', 'DESC')
                        ->addOrderBy('i.publicateDate', 'DESC')
                        ->setMaxResults(5);

                    return $this->get('service_data_response')->JsonResponse($data = $qb->getQuery()->getResult());
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

    // Fonction qui ajoute une idée
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

                    $data = json_decode($request->getContent(), true);

                    if (!empty(isset($data['title'])) && !empty(isset($data['idea']))){

                        try{
                            $idea = new Idea();
                            $idea->setTitle($data['title']);
                            $idea->setIdea($data['idea']);
                            $idea->setIdUser($user->getId());
                            $idea->setPublicateDate($date = new \DateTime());

                            if(isset($data['idCommunity'])){
                                if($data['idCommunity'] != ''){
                                    $repository = $em->getRepository('ApiBundle:Community');
                                    $community = $repository->findOneBy(array('id' => $data['idCommunity']));

                                    if($community){
                                        $idea->setIdCommunauty($data['idCommunity']);
                                    }else{
                                        return $this->get('service_errors_messages')->errorMessage("010");
                                    }
                                }
                            }

                            $em->persist($idea);
                            $em->flush();

                            $date = new \DateTime();
                            $date = $date->format('Y-m-d H:i:s');

                            $data = array(
                                'title' => $data['title'],
                                'idea' => $data['idea'],
                                'date' => $date,
                            );

                            return $this->get('service_data_response')->JsonResponse($data);

                        }catch(Exception $ex){
                            return $this->get('service_errors_messages')->errorMessage("001");
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

    public function voteAction(Request $request)
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

                    $repository = $em->getRepository('ApiBundle:Idea');

                    if(isset($data['id'])){
                        if($idea = $repository->findOneBy(array('id' => $data['id']))) {

                            $repository = $em->getRepository('ApiBundle:VoteUserIdea');

                            if($voteUserIdea = $repository->findOneBy(array('idUser' => $user->getId(), 'idIdea' => $data['id']))){

                                $em->remove($voteUserIdea);
                                $em->flush();

                                $data = array(
                                    'vote' => false,
                                );

                                return $this->get('service_data_response')->JsonResponse($data);
                            }else{

                                $voteUserIdea = new VoteUserIdea();

                                $voteUserIdea->setIdIdea($data['id']);
                                $voteUserIdea->setIdUser($user->getId());

                                $em->persist($voteUserIdea);
                                $em->flush();

                                $data = array(
                                    'vote' => true,
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
}
