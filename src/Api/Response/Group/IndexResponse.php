<?php

namespace App\Api\Response\Group;

use Symfony\Component\HttpFoundation\JsonResponse;

class IndexResponse extends JsonResponse
{
    public function __construct(array $groups)
    {
        parent::__construct();

        $data = [];
        foreach ($groups as $group) {
            $data[] = [
                "id" => $group->getId(),
                "name" => $group->getName(),
            ];
        }

        $this->setData($data);
    }
}