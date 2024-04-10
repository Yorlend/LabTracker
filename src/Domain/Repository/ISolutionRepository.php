<?php

namespace App\Domain\Repository;

use App\Domain\Model\FileModel;
use App\Domain\Model\LabState;
use App\Domain\Model\SolutionModel;

interface ISolutionRepository
{
    /**
     * @return SolutionModel[] Все отправленные решения
     */
    public function getAll(): array;

    /**
     * @param int $id
     * @return SolutionModel Результат поиска
     */
    public function getById(int $id): SolutionModel;


    /**
     * @param string $description описание
     * @param LabState $state состояние
     * @param int $labId идентификатор лабораторной
     * @param int $userId идентификатор пользователя
     * @param FileModel[] $files файлы решения
     * @return SolutionModel
     */
    public function create(
        string $description,
        LabState $state,
        int $labId,
        int $userId,
        array $files,
    ): SolutionModel;

    /**
     * @param int $id какой Solution обновлять
     * @param SolutionModel $solution обновленный Solution
     * @return void
     */
    public function update(
        int $id,
        SolutionModel $solution,
    ): void;

    /**
     * @param int $id
     * @return void
     */
    public function delete(int $id): void;
}