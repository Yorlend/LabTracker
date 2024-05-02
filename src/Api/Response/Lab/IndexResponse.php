<?php

namespace App\Api\Response\Lab;

use Symfony\Component\HttpFoundation\JsonResponse;

class IndexResponse extends JsonResponse
{
    public function __construct(array $labs)
    {
        parent::__construct();

        $data = [];
        foreach ($labs as $lab) {
            $data[] = [
                "id" => $lab->getId(),
                "name" => $lab->getName(),
            ];
        }

        $this->setData($data);
    }

}