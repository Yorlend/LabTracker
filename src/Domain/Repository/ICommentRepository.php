<?php

namespace App\Domain\Repository;

use App\Domain\Model\CommentModel;

interface ICommentRepository
{
    /**
     * @return CommentModel[] Все комментарии
     */
    public function getAll(): array;

    /**
     * @param int $id
     * @return CommentModel Результат поиска
     */
    public function getById(int $id): CommentModel;


    public function create(

    ): CommentModel;

    /**
     * @param int $id
     * @param CommentModel $comment обновленный комментарий
     * @return void
     */
    public function update(
        int $id,
        CommentModel $comment,
    ): void;

    /**
     * @param int $id
     * @return void
     */
    public function delete(int $id): void;
}