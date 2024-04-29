<?php

namespace App\Api\Response\Solution;

use Symfony\Component\HttpFoundation\JsonResponse;

class IndexResponse extends JsonResponse
{
    public function __construct(array $solution)
    {
        parent::__construct();

        $data = [];
        foreach ($solution as $sol) {
            $data[] = [
                "id" => $sol->getId(),
                "user_id" => $sol->getUser()->getId(),
                "lab_id" => $sol->getLabId(),
                "user_name" => $sol->getUser()->getUserName(),
                "state" => $sol->getState(),
            ];
        }

        $this->setData($data);
    }
}