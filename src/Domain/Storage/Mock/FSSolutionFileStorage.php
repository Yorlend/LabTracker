<?php

namespace App\Domain\Storage\Mock;

use App\Domain\Model\FileModel;
use App\Domain\Storage\ISolutionFileStorage;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class FSSolutionFileStorage implements ISolutionFileStorage
{
    private string $pathPrefix = "/var/www/symfony/test_storage/sol";
    public function save(int $labId, int $solutionId, FileModel $file): string
    {
        $path = $this->pathPrefix . "/$labId" . "/$solutionId/";
        if(!is_dir($path)){
            mkdir($path, recursive: true);
        }

        copy($file->getPath(), $path . $file->getName());

        return $path;
    }

    public function clearSolutionFiles(int $labId, int $solutionId): void
    {
        $path = $this->pathPrefix . "/$labId" . "/$solutionId/";
        if(!is_dir($path)) return;

        $files = scandir($path);
        foreach($files as $file) {
            if($file == "." || $file == "..") continue;
            unlink($path . $file);
        }

        rmdir($path);
        rmdir($this->pathPrefix . "/$labId");
    }
}