<?php

namespace App\Api\Response\User;

use App\Domain\Model\UserModel;
use Symfony\Component\HttpFoundation\JsonResponse;

class ShowResponse extends JsonResponse
{
    public function __construct(UserModel $user)
    {
        parent::__construct();

        $this->setData([
            "id" => $user->getId(),
            "user_name" => $user->getUserName()
        ]);
    }
}