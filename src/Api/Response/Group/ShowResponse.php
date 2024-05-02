<?php

namespace App\Api\Response\Group;

use App\Domain\Model\GroupModel;
use Symfony\Component\HttpFoundation\JsonResponse;

class ShowResponse extends JsonResponse
{
    public function __construct(GroupModel $group)
    {
        parent::__construct();

        $this->setData([
            "id" => $group->getId(),
            "name" => $group->getName(),
            "teacher_id" => $group->getTeacher()
        ]);
    }
}