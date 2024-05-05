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
        mkdir($path, recursive: true);

        copy($file->getPath(), $path . $file->getName());

        return $path . $file->getName();
    }

    public function clearSolutionFiles(int $labId, int $solutionId): void
    {
        $path = $this->pathPrefix . "/$labId" . "/$solutionId/";
        $it = new RecursiveDirectoryIterator($path, RecursiveDirectoryIterator::SKIP_DOTS);
        $files = new RecursiveIteratorIterator($it,
                    RecursiveIteratorIterator::CHILD_FIRST);
        foreach($files as $file) {
            if ($file->isDir()){
                rmdir($file->getPathname());
            } else {
                unlink($file->getPathname());
            }
        }
        rmdir($path);
    }
}