<?php

namespace App\Domain\Repository;

use App\Domain\Model\FileModel;

/**
 * Интерфейс репозитория дескрипторов файлов
 */
interface IFileRepository
{

    /**
     * Получить дескриптор по id
     *
     * @param int $id
     * @return FileModel Результат поиска
     */
    public function getById(int $id): FileModel;

    /**
     * Создать дескриптор для лабы
     *
     * @param string $path путь к файлу
     * @param string $name имя
     * @param int $labId id лабы, к которой относится файл
     * @return FileModel
     */
    public function createForLab(
        string $path,
        string $name,
        int    $labId,
    ): FileModel;

    /**
     * Создать дескриптор для решения
     *
     * @param string $path путь к файлу
     * @param string $name имя
     * @param int $solutionId id решения, к которому относится файл
     * @return FileModel
     */
    public function createForSolution(
        string $path,
        string $name,
        int    $solutionId,
    ): FileModel;

    /**
     * Удалить все дескрипторы лабы
     *
     * @param int $labId id лабы, для которой удаляются файлы
     * @return void
     */
    public function deleteByLabID(int $labId): void;

    /**
     * Удалить все дескрипторы решения
     *
     * @param int $labId id решения, для которого удаляются файлы
     * @return void
     */
    public function deleteBySolutionID(int $labId): void;
}