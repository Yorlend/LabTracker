<?php

namespace App\Domain\Model;

readonly class CommentModel
{
    /**
     * @param int $id
     * @param string $text комментарий
     * @param int $date дата проверки
     * @param SolutionModel $solution решение, к которому оставлен коментарий
     * @param UserModel $reviewer преподаватель
     */
    public function __construct(
        private int $id,
        private string $text,
        private int $date,
        private SolutionModel $solution,
        private UserModel $reviewer,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getDate(): int
    {
        return $this->date;
    }

    public function getSolution(): SolutionModel
    {
        return $this->solution;
    }

    public function getReviewer(): UserModel
    {
        return $this->reviewer;
    }


}