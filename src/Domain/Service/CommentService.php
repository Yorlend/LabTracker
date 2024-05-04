<?php

namespace App\Domain\Service;

use App\Domain\Model\CommentModel;
use App\Domain\Repository\ICommentRepository;
use App\Data\MSCommentRepository;
/**
 * Сервис для работы с комментариями
 */
class CommentService
{
    /**
     * @param ICommentRepository $repository репозиторий коментариев
     */
    public function __construct(private readonly MSCommentRepository $repository)
    {
    }

    /**
     * Создать комментарий
     *
     * @param int $solutionId id решения
     * @param string $text текст комментария
     * @param int $userId id пользователя
     * @return int id созданного комментария
     */
    public function create(
        int    $solutionId,
        string $text,
        int    $userId
    ): int
    {
        return $this->repository->create($solutionId, $text, $userId)->getId();
    }

    /**
     * Получить комментарии, связанные с решением
     *
     * @param int $solutionId id решения
     * @return CommentModel[] комменнтраии к решению
     */
    public function getBySolutionId(
        int $solutionId,
    ): array
    {
        return $this->repository->getBySolutionId($solutionId);
    }

    /**
     * Обновить комментарий
     *
     * @param int $id id комментария
     * @param string $text обновлённый текст
     * @return void
     */
    public function update(int $id, string $text): void
    {
        $this->repository->update($id, $text);
    }

    /**
     * Удалить комментарий
     *
     * @param int $id id комментария
     * @return void
     */
    public function delete(int $id): void
    {
        $this->repository->delete($id);
    }
}