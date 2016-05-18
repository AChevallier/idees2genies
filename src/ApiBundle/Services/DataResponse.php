<?php

namespace ApiBundle\Services;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;


class DataResponse
{
    public function __construct() {

    }

    // Fonction qui renvoie la réponse en JSON avec un code 200
    public function JsonResponse($data){

        $response =  new Response(json_encode($data,JSON_UNESCAPED_UNICODE), 200);
        $response->headers->set('Access-Control-Allow-Origin', 'http://localhost:3000');
        $response->headers->set('Content-Type', 'application/json');

        return $response;


    }
}