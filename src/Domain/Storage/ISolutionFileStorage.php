<?php

namespace App\Domain\Storage;

use App\Domain\Model\FileModel;

/**
 * Интерфейс файлового хранилища решений
 */
interface ISolutionFileStorage
{
    /**
     * Сохранить файл
     *
     * @param int $labId id лабы
     * @param int $solutionId id решения
     * @param FileModel $file дескриптор файла для сохранения
     * @return string путь до файла в постоянном хранилище
     */
    public function save(int $labId, int $solutionId, FileModel $file): string;

    /**
     * Очистить директорию решения
     *
     * @param int $labId id группы
     * @param int $solutionId id решения
     * @return void
     */
    public function clearSolutionFiles(int $labId, int $solutionId): void;
}