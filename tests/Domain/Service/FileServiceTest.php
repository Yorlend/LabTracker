<?php

namespace App\Tests\Domain\Service;

use App\Domain\Model\FileModel;
use App\Domain\Service\FileService;
use PHPUnit\Framework\TestCase;

class FileServiceTest extends TestCase
{
        public function testGetFiles(): void
    {
        $model = new FileModel(1, 'name1', 'path1');

        $mockFIleRepo = $this->getMockBuilder('App\Domain\Repository\IFileRepository')
            ->onlyMethods(array('getById', 'createForLab', 'createForSolution','deleteByLabID', 'deleteBySolutionID'))
            ->getMock();
        $mockFIleRepo
            ->expects($this->once())
            ->method('getById')
            ->with($model->getId())
            ->willReturn($model);

        $service = new FileService($mockFIleRepo);

        $actual = $service->getFile($model->getId());

        $this->assertSame($model, $actual);
    }
}