<?php

namespace App\Domain\Storage;

interface ILabFileStorage
{
    /**
     * @param int $groupID id группы
     * @param int $labId id лабы
     * @param array $files пути к файлам
     * @return void
     */
    public function save(int $groupID, int $labId, array $files): void;

    /**
     * @param int $groupID id лабы
     * @param int $labId id группы
     * @return void
     */
    public function clearLabFiles(int $groupID, int $labId): void;

    /**
     * @param int $groupID id лабы
     * @param int $labId id группы
     * @param string $name имя файла
     * @return string путь к файлу
     */
    public function getFilePath(int $groupID, int $labId, string $name): string;
}