<?php

namespace App\Tests\Domain\Service;

use App\Domain\Model\FileModel;
use App\Domain\Model\LabModel;
use App\Domain\Service\LabService;
use PHPUnit\Framework\TestCase;

class LabServiceTest extends TestCase
{

    public function testCreate(): void
    {
        $files = ['path1/name1'];
        $expected = new LabModel(
            1,
            'name',
            'desc',
            1,
            [
                new FileModel(1, 'name1', 'path1'),
            ]
        );

        $mockRepo = $this->getMockBuilder('App\Domain\Repository\ILabRepository')
            ->onlyMethods(array('getAll', 'getById', 'create', 'update', 'delete'))
            ->getMock();
        $mockRepo
            ->expects($this->once())
            ->method('create')
            ->with($expected->getName(), $expected->getDescription(), $expected->getGroupId())
            ->willReturn($expected);

        $mockFIleRepo = $this->getMockBuilder('App\Domain\Repository\IFileRepository')
            ->onlyMethods(array('getById', 'createForLab', 'createForSolution','deleteByLabID', 'deleteBySolutionID'))
            ->getMock();

        $mockStorage = $this->getMockBuilder('App\Domain\Storage\ILabFileStorage')
            ->onlyMethods(array('save', 'clearLabFiles'))
            ->getMock();

        $service = new LabService($mockRepo, $mockFIleRepo, $mockStorage);

        $actual = $service->create($expected->getName(), $expected->getDescription(), $expected->getGroupId(), $files);

        $this->assertSame($expected->getId(), $actual);
    }

    public function testGetAll(): void
    {
        $expected = [new LabModel(
            1,
            'name',
            'desc',
            1,
            [
                new FileModel(1, 'name1', 'path1'),
                new FileModel(2, 'name2', 'path2'),
            ]
        )];

        $mockRepo = $this->getMockBuilder('App\Domain\Repository\ILabRepository')
            ->onlyMethods(array('getAll', 'getById', 'create', 'update', 'delete'))
            ->getMock();
        $mockRepo
            ->expects($this->once())
            ->method('getAll')
            ->willReturn($expected);

        $mockFIleRepo = $this->getMockBuilder('App\Domain\Repository\IFileRepository')
            ->onlyMethods(array('getById', 'createForLab', 'createForSolution','deleteByLabID', 'deleteBySolutionID'))
            ->getMock();

        $mockStorage = $this->getMockBuilder('App\Domain\Storage\ILabFileStorage')
            ->onlyMethods(array('save', 'clearLabFiles'))
            ->getMock();

        $service = new LabService($mockRepo, $mockFIleRepo, $mockStorage);

        $actual = $service->getAll();

        $this->assertSame($expected, $actual);
    }

    public function testGet(): void
    {
        $expected = new LabModel(
            1,
            'name',
            'desc',
            1,
            [
                new FileModel(1, 'name1', 'path1'),
                new FileModel(2, 'name2', 'path2'),
            ]
        );

        $mockRepo = $this->getMockBuilder('App\Domain\Repository\ILabRepository')
            ->onlyMethods(array('getAll', 'getById', 'create', 'update', 'delete'))
            ->getMock();
        $mockRepo
            ->expects($this->once())
            ->method('getById')
            ->with(1)
            ->willReturn($expected);

        $mockFIleRepo = $this->getMockBuilder('App\Domain\Repository\IFileRepository')
            ->onlyMethods(array('getById', 'createForLab', 'createForSolution','deleteByLabID', 'deleteBySolutionID'))
            ->getMock();

        $mockStorage = $this->getMockBuilder('App\Domain\Storage\ILabFileStorage')
            ->onlyMethods(array('save', 'clearLabFiles'))
            ->getMock();

        $service = new LabService($mockRepo, $mockFIleRepo, $mockStorage);

        $actual = $service->get(1);

        $this->assertSame($expected, $actual);
    }

    public function testDelete(): void
    {
        $mockRepo = $this->getMockBuilder('App\Domain\Repository\ILabRepository')
            ->onlyMethods(array('getAll', 'getById', 'create', 'update', 'delete'))
            ->getMock();
        $mockRepo
            ->expects($this->once())
            ->method('delete')
            ->with(1);

        $mockFIleRepo = $this->getMockBuilder('App\Domain\Repository\IFileRepository')
            ->onlyMethods(array('getById', 'createForLab', 'createForSolution','deleteByLabID', 'deleteBySolutionID'))
            ->getMock();

        $mockStorage = $this->getMockBuilder('App\Domain\Storage\ILabFileStorage')
            ->onlyMethods(array('save', 'clearLabFiles'))
            ->getMock();

        $service = new LabService($mockRepo, $mockFIleRepo, $mockStorage);

        $service->delete(1);
    }

    public function testUpdate(): void
    {
        $model = new LabModel(
            1,
            'name',
            'desc',
            1,
            [
                new FileModel(1, 'name1', 'path1'),
                new FileModel(2, 'name2', 'path2'),
            ]
        );

        $mockRepo = $this->getMockBuilder('App\Domain\Repository\ILabRepository')
            ->onlyMethods(array('getAll', 'getById', 'create', 'update', 'delete'))
            ->getMock();
        $mockRepo
            ->expects($this->once())
            ->method('update')
            ->with(1, 'name', 'desc', 1);

        $mockFIleRepo = $this->getMockBuilder('App\Domain\Repository\IFileRepository')
            ->onlyMethods(array('getById', 'createForLab', 'createForSolution','deleteByLabID', 'deleteBySolutionID'))
            ->getMock();

        $mockStorage = $this->getMockBuilder('App\Domain\Storage\ILabFileStorage')
            ->onlyMethods(array('save', 'clearLabFiles'))
            ->getMock();

        $service = new LabService($mockRepo, $mockFIleRepo, $mockStorage);

        $service->update(1, 'name', 'desc', 1);
    }

    public function testUpdateFiles(): void
    {
        $files = [new FileModel(1, 'name1', 'path1')];
        $model = new LabModel(
            1,
            'name',
            'desc',
            1,
            $files
        );

        $mockRepo = $this->getMockBuilder('App\Domain\Repository\ILabRepository')
            ->onlyMethods(array('getAll', 'getById', 'create', 'update', 'delete'))
            ->getMock();
        $mockRepo
            ->expects($this->once())
            ->method('getById')
            ->with($model->getId())
            ->willReturn($model);

        $constPath = "pathcnst";
        $mockFIleRepo = $this->getMockBuilder('App\Domain\Repository\IFileRepository')
            ->onlyMethods(array('getById', 'createForLab', 'createForSolution','deleteByLabID', 'deleteBySolutionID'))
            ->getMock();
        $mockFIleRepo
            ->expects($this->once())
            ->method('deleteByLabID')
            ->with($model->getId());
        $mockFIleRepo
            ->expects($this->once())
            ->method('createForLab')
            ->with($constPath, $files[0]->getName(), $model->getId())
            ->willReturn($files[0]);

        $mockStorage = $this->getMockBuilder('App\Domain\Storage\ILabFileStorage')
            ->onlyMethods(array('save', 'clearLabFiles'))
            ->getMock();
        $mockStorage
            ->expects($this->once())
            ->method('clearLabFiles')
            ->with($model->getGroupId(), $model->getId());
        $mockStorage
            ->expects($this->once())
            ->method('save')
            ->with($model->getGroupId(), $model->getId(), $files[0])
            ->willReturn($constPath);

        $service = new LabService($mockRepo, $mockFIleRepo, $mockStorage);

        $service->updateFiles($model->getId(), $files);
    }
}