<?php

namespace App\Api\Response\Lab;

use App\Domain\Model\LabModel;
use Symfony\Component\HttpFoundation\JsonResponse;

class ShowResponse extends JsonResponse
{
    public function __construct(LabModel $lab)
    {
        parent::__construct();

        $files = [];
        foreach ($lab->getFiles() as $file){
            $files[] = [
                "id" => $file->getId(),
                "name" => $file->getName()
            ];
        }

        $this->setData([
            "id" => $lab->getId(),
            "name" => $lab->getName(),
            "description" => $lab->getDescription(),
            "group_id" => $lab->getGroupId(),
            "files" => $files
        ]);
    }
}