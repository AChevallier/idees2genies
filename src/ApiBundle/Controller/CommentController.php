<?php

namespace ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use ApiBundle\Entity\User;
use ApiBundle\Entity\Idea;
use ApiBundle\Entity\Comment;
use ApiBundle\Entity\VoteUserComment;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 * Cette classe permet la gestion des commentaires
 */
class CommentController extends Controller
{

    /**
     * Creation d’un utilisateur
     * @author Steve Vandycke, Alexandre Chevallier, Charles Grimont, Thibault Tichet
     * @param JSON d'ajout d'un commentaire
     * @return JSON de retour d'ajout de commentaire
     */
    public function addAction(Request $request)
    {
        try{
            $token = $request->headers->get('token');

            $em = $this->getDoctrine()->getEntityManager();
            $repository = $em->getRepository('ApiBundle:User');
            $data = json_decode($request->getContent(), true);
            $user = $repository->findOneBy(array('token' => $token));

            if($user){
                $valideToken = $user->getValideToken();
                $idUser = $user->getId();
                $date = new \DateTime();

                if($valideToken > $date){

                    if(isset($data['comment']) && isset($data['idIdea'])){
                        if($data['comment'] != ""){
                            $repository = $em->getRepository('ApiBundle:Idea');
                            if($idea = $repository->findOneBy(array('id' => $data['idIdea']))){

                                $comment = new Comment();
                                $comment->setComment($data['comment']);
                                $comment->SetIdIdea($data['idIdea']);
                                $comment->setPublicateDate($date = new \DateTime());
                                $comment->setIdUser($user->getId());

                                $em->persist($comment);
                                $em->flush();

                                $data = array(
                                    'comment' => $data['comment'],
                                );

                                return $this->get('service_data_response')->JsonResponse($data);
                            }else{
                                return $this->get('service_errors_messages')->errorMessage("011");
                            }
                        }else{
                            return $this->get('service_errors_messages')->errorMessage("013");
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
     * Fonction qui permet de voter pour un commentaire
     * @author Steve Vandycke, Alexandre Chevallier, Charles Grimont, Thibault Tichet
     * @param JSON contenant l'ID du commentaire
     * @return JSON de retour d'un vote pour un commentaire
     */
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
                    $repository = $em->getRepository('ApiBundle:Comment');

                    if(isset($data['id'])){
                        if($comment = $repository->findOneBy(array('id' => $data['id']))) {

                            $repository = $em->getRepository('ApiBundle:VoteUserComment');

                            if($voteUserComment = $repository->findOneBy(array('idUser' => $user->getId(), 'idComment' => $data['id']))){

                                $em->remove($voteUserComment);
                                $em->flush();

                                $data = array(
                                    'vote' => false,
                                );

                                return $this->get('service_data_response')->JsonResponse($data);
                            }else{

                                $voteUserComment = new VoteUserComment();

                                $voteUserComment->setIdComment($data['id']);
                                $voteUserComment->setIdUser($user->getId());

                                $em->persist($voteUserComment);
                                $em->flush();

                                $data = array(
                                    'vote' => true,
                                );

                                return $this->get('service_data_response')->JsonResponse($data);
                            }
                        }else{
                            return $this->get('service_errors_messages')->errorMessage("014");
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