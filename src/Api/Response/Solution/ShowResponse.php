<?php

namespace App\Api\Response\Solution;

use App\Domain\Model\SolutionModel;
use Symfony\Component\HttpFoundation\JsonResponse;

class ShowResponse extends JsonResponse
{
    public function __construct(SolutionModel $sol)
    {
        parent::__construct();

        $files = [];
        foreach ($sol->getFiles() as $file) {
            $files[] = [
                "id" => $file->getId(),
                "name" => $file->getName()
            ];
        }

        $this->setData([
            "id" => $sol->getId(),
            "user_id" => $sol->getUser()->getId(),
            "lab_id" => $sol->getLabId(),
            "user_name" => $sol->getUser()->getUserName(),
            "state" => $sol->getState(),
            "files" => $files
        ]);
    }
}