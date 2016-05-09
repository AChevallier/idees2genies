<?php

namespace ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserController extends Controller
{
    public function indexAction()
    {
        $reponse = new JsonResponse();
        $reponse -> setData(array(
                'date' => date(("d-m-Y G:i:s"))
            ));
        return $reponse;
    }

    public function addAction()
    {
        $reponse = new JsonResponse();
        $reponse -> setData(array(
                'date' => date(("-m-Y G:i:s"))
            ));
        return $reponse;
    }
}
