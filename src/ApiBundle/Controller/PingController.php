<?php

namespace ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use ApiBundle\Entity\User;
use ApiBundle\Entity\UserCommunity;
use ApiBundle\Entity\Community;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;


class PingController extends Controller
{
    public function indexAction()
    {

        $dateNow = new \DateTime();
        $date = $dateNow->format('Y-m-d H:i:s');


        $data = array(
            'date' => $date
        );
        return $this->get('service_data_response')->JsonResponse($data);
    }

    public function postAction()
    {

        $params = array();
        $content = $this->get("request")->getContent();
        if (!empty($content)) {
            $params = json_decode($content, true);
        }

        $tableData = array(
            'name' => $params['name'],
            'message' => 'Nom bien reçu !'
        );

        return $this->get('service_data_response')->JsonResponse($tableData);
    }

    public  function innerAction(){

        /*$em = $this->getDoctrine()->getEntityManager();
        $videos = $em->createQuery('select uc, u
                            from ApiBundle:UserCommunity uc
                            left join ApiBundle:User u
                            where uc.idCommunity = u.id')
            ->getResult();

        $parameters=$videos->getParameters();*/

        // OK ci-après

        /*$em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('SELECT u FROM ApiBundle:User u WHERE u.name = :name')->setParameter('name', 'VANDYCKE');

        $products = $query->getResult();
        $name = $products[0]->getFirstName();*/

        return new Response("essai");
    }
}
