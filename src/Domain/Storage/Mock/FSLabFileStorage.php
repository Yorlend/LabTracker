<?php

namespace App\Domain\Storage\Mock;

use App\Domain\Model\FileModel;
use App\Domain\Storage\ILabFileStorage;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class FSLabFileStorage implements ILabFileStorage
{

    private string $pathPrefix = "/var/www/symfony/test_storage/lab";

    public function save(int $groupID, int $labId, FileModel $file): string
    {
        $path = $this->pathPrefix . "/$groupID" . "/$labId/";
        if(!is_dir($path)){
            mkdir($path, recursive: true);
        }

        copy($file->getPath(), $path . $file->getName());

        return $path;
    }

    public function clearLabFiles(int $groupID, int $labId): void
    {
        $path = $this->pathPrefix . "/$groupID" . "/$labId/";
        if(!is_dir($path)) return;

        $files = scandir($path);
        foreach($files as $file) {
            if($file == "." || $file == "..") continue;
            unlink($path . $file);
        }

        rmdir($path);
        rmdir($this->pathPrefix . "/$groupID");
    }
}