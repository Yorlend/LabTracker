<?php

namespace App\Domain\Repository;

use App\Domain\Model\LabModel;

/**
 * Интерфейс репозитория лаб
 */
interface ILabRepository
{
    /**
     * Получить все лабы
     *
     * @param int|null $groupId id группы, для фильтрации
     * @return LabModel[] Все лабораторные
     */
    public function getAll(?int $groupId): array;

    /**
     * Получить лабу по id
     *
     * @param int $id
     * @return LabModel Результат поиска
     */
    public function getById(int $id): LabModel;

    /**
     * Создать лабу
     *
     * @param string $name название
     * @param string $description описание
     * @param int $groupId идентификатор группы
     * @return LabModel
     */
    public function create(
        string $name,
        string $description,
        int    $groupId,
    ): LabModel;

    /**
     * Обновить лабу
     *
     * @param int $id id лабы
     * @param string $name имя лабы
     * @param string $description описание лабы
     * @param int $groupId id группы
     * @return void
     */
    public function update(
        int    $id,
        string $name,
        string $description,
        int    $groupId,
    ): void;


    /**
     * Удалить лабу
     *
     * @param int $id
     * @return void
     */
    public function delete(int $id): void;
}