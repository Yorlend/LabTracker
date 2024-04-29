<?php

namespace App\Domain\Storage;

use App\Domain\Model\FileModel;

/**
 * Интерфейс файлового хранилища лаб
 */
interface ILabFileStorage
{
    /**
     * Сохранить файл
     *
     * @param int $groupID id группы
     * @param int $labId id лабы
     * @param FileModel $file дескриптор файла для сохранения
     * @return string путь до файла в постоянном хранилище
     */
    public function save(int $groupID, int $labId, FileModel $file): string;

    /**
     * Очистить директорию лабы
     *
     * @param int $groupID id лабы
     * @param int $labId id группы
     * @return void
     */
    public function clearLabFiles(int $groupID, int $labId): void;
}