<?php

namespace App\Domain\Repository;

use App\Domain\Model\CommentModel;

/**
 * Интерфейс репозитория комментариев
 */
interface ICommentRepository
{
    /**
     * Создать комментарий
     *
     * @param int $solutionId id решения
     * @param string $text текст комментария
     * @param int $userId id пользователя
     * @return CommentModel созданный комментарий
     */
    public function create(
        int    $solutionId,
        string $text,
        int    $userId
    ): CommentModel;

    /**
     * Получить комментарии, связанные с решением
     *
     * @param int $solutionId id решения
     * @return CommentModel[] комменнтраии к решению
     */
    public function getBySolutionId(
        int $solutionId,
    ): array;

    /**
     * Обновить комментарий
     *
     * @param int $id
     * @param string $text обновлённый текст
     * @return void
     */
    public function update(
        int    $id,
        string $text
    ): void;

    /**
     * Удалить комментарий
     *
     * @param int $id
     * @return void
     */
    public function delete(int $id): void;
}