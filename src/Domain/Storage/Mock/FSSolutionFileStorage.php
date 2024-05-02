<?php

namespace App\Domain\Storage\Mock;

use App\Domain\Model\FileModel;
use App\Domain\Storage\ISolutionFileStorage;

class FSSolutionFileStorage implements ISolutionFileStorage
{
    private string $pathPrefix = "/var/www/symfony/test_storage/sol";
    public function save(int $labId, int $solutionId, FileModel $file): string
    {
        $path = $this->pathPrefix . "/$labId" . "/$solutionId/";
        mkdir($path, recursive: true);

        copy($file->getPath(), $path . $file->getName());

        return $path . $file->getName();
    }

    public function clearSolutionFiles(int $labId, int $solutionId): void
    {

    }
}