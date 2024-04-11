<?php

namespace App\Domain\Repository;

use App\Domain\Model\CommentModel;

interface ICommentRepository
{
    /**
     * @param int $solutionId id решения
     * @param string $text текст комментария
     * @return CommentModel
     */
    public function create(
        int    $solutionId,
        string $text
    ): CommentModel;

    /**
     * @param int $id
     * @param CommentModel $comment обновленный комментарий
     * @return void
     */
    public function update(
        int          $id,
        CommentModel $comment,
    ): void;

    /**
     * @param int $id
     * @return void
     */
    public function delete(int $id): void;
}