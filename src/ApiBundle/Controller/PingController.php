<?php

namespace ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

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
}
