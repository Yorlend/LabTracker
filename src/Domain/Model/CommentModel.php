<?php

namespace App\Domain\Model;

readonly class CommentModel
{
    /**
     * @param int $id
     * @param string $text комментарий
     * @param string $date дата проверки
     * @param UserModel $user пользователь, оставивший комментарий
     */
    public function __construct(
        private int       $id,
        private string    $text,
        private string    $date,
        private UserModel $user,
    )
    {
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

    public function getUser(): UserModel
    {
        return $this->user;
    }


}