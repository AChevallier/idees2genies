<?php

namespace ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use ApiBundle\Entity\User;
use ApiBundle\Entity\Idea;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


class IdeaController extends Controller
{

    // Fonction homePage de user
    public function indexAction()
    {
        return new JsonResponse("Idea");
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

                            if(isset($data['idCommunity'])){

                                $repository = $em->getRepository('ApiBundle:Community');
                                $community = $repository->findOneBy(array('id' => $data['idCommunity']));

                                if($community){
                                    $idea->setIdCommunauty($data['idCommunity']);
                                }else{
                                    return $this->get('service_errors_messages')->errorMessage("010");
                                }
                            }

                            $em->persist($idea);
                            $em->flush();

                            $data = array(
                                'title' => $data['title'],
                                'idea' => $data['idea'],
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
}
