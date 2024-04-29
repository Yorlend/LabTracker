<?php

namespace App\Domain\Storage\Mock;

use App\Domain\Model\FileModel;
use App\Domain\Storage\ILabFileStorage;

class FSLabFileStorage implements ILabFileStorage
{

    private string $pathPrefix = "/var/www/symfony/test_storage/lab";

    public function save(int $groupID, int $labId, FileModel $file): string
    {
        $path = $this->pathPrefix . "/$groupID" . "/$labId/";
        mkdir($path, recursive: true);

        copy($file->getPath(), $path . $file->getName());

        return $path . $file->getName();
    }

    public function clearLabFiles(int $groupID, int $labId): void
    {

    }
}