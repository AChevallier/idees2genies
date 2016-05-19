<?php

namespace ApiBundle\Services;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;


class DataResponse
{
    public function __construct()
    {
    }

    // Fonction qui renvoie la réponse en JSON avec un code 200
    public function JsonResponse($data){

        $response = new JsonResponse(json_encode($data,JSON_UNESCAPED_UNICODE), 200);

        return $response;
    }
}