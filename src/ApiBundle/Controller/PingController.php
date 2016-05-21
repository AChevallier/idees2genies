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

    // Fonction pour tester le post
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

    // Fonction pour tester inner join
    public  function innerAction(){

        $em = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder()
            ->select('u.name AS nameUser, uc.id AS idUserCommunity, uc.idCommunity AS idCommunity, c.description AS descriptionCommunity, c.name AS nameCommunity')
            ->from('ApiBundle:UserCommunity', 'uc')
            ->innerJoin('ApiBundle:User', 'u', 'WITH', 'uc.idUser = u.id')
            ->innerJoin('ApiBundle:Community', 'c', 'WITH', 'uc.idCommunity = c.id')
            ->where('u.name = :name')
            ->setParameters(array('name' => 'VANDYCKE'))
        ;
        $data = $qb->getQuery()->getResult();

        $tableData = array(
            'community' => $data
        );

        return $this->get('service_data_response')->JsonResponse($tableData);
    }
}
