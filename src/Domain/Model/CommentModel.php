<?php

namespace App\Domain\Model;

/**
 *  Сущность комментария
 */
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

    /**
     * @return int id
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string текст
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @return string дата
     */
    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * @return UserModel создатель комментария
     */
    public function getUser(): UserModel
    {
        return $this->user;
    }


}