<?php

namespace App\Api\Response\User;

use Symfony\Component\HttpFoundation\JsonResponse;

class IndexResponse extends JsonResponse
{
    public function __construct(array $users)
    {
        parent::__construct();

        $data = [];
        foreach ($users as $user) {
            $data[] = [
                "id" => $user->getId(),
                "user_name" => $user->getUserName()
            ];
        }

        $this->setData($data);
    }
}