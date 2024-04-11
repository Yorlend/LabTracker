<?php

namespace App\Tests\Domain\Service;

use App\Domain\Model\FileModel;
use App\Domain\Service\FileService;
use PHPUnit\Framework\TestCase;

class FileServiceTest extends TestCase
{
    public function testGet(): void
    {
        $expected = new FileModel(1, 'name', 'path');

        $mockRepo = $this->getMockBuilder('App\Domain\Repository\IFileRepository')
            ->onlyMethods(array('getAll', 'getById', 'createForLab', 'createForSolution', 'update', 'delete', 'deleteByLabID', 'deleteBySolutionID'))
            ->getMock();
        $mockRepo
            ->expects($this->once())
            ->method('getById')
            ->with(1)
            ->willReturn($expected);
        $service = new FileService($mockRepo);

        $actual = $service->get(1);

        $this->assertSame($expected, $actual);
    }
}