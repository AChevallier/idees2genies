<?php

namespace ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use ApiBundle\Entity\Community;
use Symfony\Component\HttpFoundation\Response;

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

        return new Response(json_encode($tableCommunitys,JSON_UNESCAPED_UNICODE));
    }

    // Ajoute une communauté
    public function addAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $a = new Community();
        $a->setName("PRIsm");
        $a->setDescription("Le groupe concerne la classe.");

        $em->persist($a);
        $em->flush();

        return new Response("Communauté ajoutée");
    }
}
