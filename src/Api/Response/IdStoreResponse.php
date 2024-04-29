<?php

namespace App\Api\Response;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class IdStoreResponse extends JsonResponse
{
    public function __construct(int $id)
    {
        parent::__construct();
        $this->setData(['id' => $id]);
        $this->setStatusCode(Response::HTTP_CREATED);
    }
}