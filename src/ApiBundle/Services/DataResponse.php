<?php

namespace ApiBundle\Services;
use Symfony\Component\HttpFoundation\JsonResponse;


class DataResponse
{
    public function __construct() {

    }

    // Fonction qui renvoie la réponse en JSON avec un code 200
    public function JsonResponse($data){

        $response = json_encode($data,JSON_UNESCAPED_UNICODE);
        $response =  new JsonResponse($response, 200);
        $response->headers->set('Access-Control-Allow-Origin', 'http://localhost:3000');

        return $response;
    }
}