<?php

namespace App\Api\Response;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class NoContentResponse extends JsonResponse
{
    public function __construct()
    {
        parent::__construct();
        $this->setStatusCode(Response::HTTP_NO_CONTENT);
    }

}