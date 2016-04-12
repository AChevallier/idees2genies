<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class PingController
{
    /**
     * @Route("/PingS/", name="Ping")
     */
    public function pingAction()
    {
        $reponse = new JsonResponse();
        $reponse -> setData(array(
                'date' => date(("d-m-Y G:i:s"))
            ));
        return $reponse;
    }
}