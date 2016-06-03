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

/**
 * Cette classe permet de tester le serveur
 */
class PingController extends Controller
{

    /**
     * Teste de réponse du web service
     * @author Steve Vandycke, Alexandre Chevallier, Charles Grimont, Thibault Tichet
     * @param Aucun paramètres
     * @return JSON de retour du teste du serveur
     */
    public function indexAction()
    {

        $dateNow = new \DateTime();
        $date = $dateNow->format('Y-m-d H:i:s');


        $data = array(
            'date' => $date
        );
        return $this->get('service_data_response')->JsonResponse($data);
    }

    /**
     * Tester le post
     * @author Steve Vandycke, Alexandre Chevallier, Charles Grimont, Thibault Tichet
     * @param JSON du test de post
     * @return JSON de retour d'une liste d'idées
     */
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

    /**
     * Tester inner join
     * @author Steve Vandycke, Alexandre Chevallier, Charles Grimont, Thibault Tichet
     * @param Aucun paramètres
     * @return JSON de retour du test du inner join
     */
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
