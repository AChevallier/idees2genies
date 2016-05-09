<?php

namespace ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class PingController extends Controller
{
    public function indexAction()
    {
        $reponse = new JsonResponse();
        $reponse -> setData(array(
                'date' => date(("d-m-Y G:i:s"))
            ));
        return $reponse;
    }
}
