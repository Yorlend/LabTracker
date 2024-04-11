<?php

namespace App\Domain\Storage;

interface ISolutionFileStorage
{
    /**
     * @param int $labId id лабы
     * @param int $solutionId id решения
     * @param array $files пути к файлам
     * @return void
     */
    public function save(int $labId, int $solutionId, array $files): void;

    /**
     * @param int $labId id группы
     * @param int $solutionId id решения
     * @return void
     */
    public function clearSolutionFiles(int $labId, int $solutionId): void;
}