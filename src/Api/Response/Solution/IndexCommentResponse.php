<?php

namespace App\Api\Response\Solution;

use Symfony\Component\HttpFoundation\JsonResponse;

class IndexCommentResponse extends JsonResponse
{
    public function __construct(array $comments)
    {
        parent::__construct();

        $data = [];
        foreach ($comments as $comment) {
            $data[] = [
                "id" => $comment->getId(),
                "user_id" => $comment->getUser()->getId(),
                "user_name" => $comment->getUser()->getUserName(),
                "date" => $comment->getDate(),
                "text" => $comment->getText(),
            ];
        }

        $this->setData($data);
    }
}