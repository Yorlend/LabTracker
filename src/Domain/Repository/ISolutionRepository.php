<?php

namespace App\Domain\Repository;

use App\Domain\Model\SolutionState;
use App\Domain\Model\SolutionModel;

/**
 * Интерфейс репозитория решений
 */
interface ISolutionRepository
{
    /**
     * Получить все решения
     *
     * @param int|null $labId id лабы, для фильтрации
     * @param SolutionState|null $state состояние, для фильтрации
     * @return SolutionModel[] все решения
     */
    public function getAll(?int $labId, ?SolutionState $state): array;

    /**
     * Получить решение по id
     *
     * @param int $id
     * @return SolutionModel Результат поиска
     */
    public function getById(int $id): SolutionModel;


    /**
     * Создать решение
     *
     * @param string $description описание
     * @param SolutionState $state состояние
     * @param int $labId идентификатор лабораторной
     * @param int $userId идентификатор пользователя
     * @return SolutionModel
     */
    public function create(
        string        $description,
        SolutionState $state,
        int           $labId,
        int           $userId,
    ): SolutionModel;

    /**
     * Обновить решение
     *
     * @param int $id какой Solution обновлять
     * @param string $description описание
     * @param SolutionState $state состояние
     * @return void
     */
    public function update(
        int           $id,
        string        $description,
        SolutionState $state,
    ): void;

    /**
     * Удалить решение
     *
     * @param int $id
     * @return void
     */
    public function delete(int $id): void;

    /**
     * Проверка id создателя
     *
     * @param int $userId id предполагаемого создателя
     * @param int $solId id решения
     * @return bool является ли пользователь создателем
     */
    public function isOwner(int $userId, int $solId): bool;
}