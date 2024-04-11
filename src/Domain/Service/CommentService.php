<?php

namespace App\Domain\Service;

use App\Domain\Model\CommentModel;
use App\Domain\Repository\ICommentRepository;

class CommentService
{
    /**
     * @param ICommentRepository $repository репозиторий коментариев
     */
    public function __construct(private readonly ICommentRepository $repository)
    {
    }

    /**
     * @param int $solutionId id решения
     * @param string $text текст комментария
     * @return int id созданного комментария
     */
    public function create(
        int    $solutionId,
        string $text
    ): int
    {
        return $this->repository->create($solutionId, $text)->getId();
    }

    /**
     * @param int $id id коментария
     * @return void
     */
    public function delete(int $id): void
    {
        $this->repository->delete($id);
    }

    /**
     * @param int $id id пользователя
     * @param CommentModel $comment обновленный пользователь
     * @return void
     */
    public function update(int $id, CommentModel $comment): void
    {
        $this->repository->update($id, $comment);
    }
}