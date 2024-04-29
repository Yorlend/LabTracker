<?php

namespace App\Tests\Domain\Service;

use App\Domain\Model\FileModel;
use App\Domain\Model\Role;
use App\Domain\Model\SolutionModel;
use App\Domain\Model\SolutionState;
use App\Domain\Model\UserModel;
use App\Domain\Service\SolutionService;
use PHPUnit\Framework\TestCase;

class SolutionServiceTest extends TestCase
{
    public function testCreate(): void
    {
        $files = ['path1/name1'];
        $expected = new SolutionModel(
            1,
            'desc',
            SolutionState::Checking,
            1,
            new UserModel(1, 'name1', 'login1', 'pass1', Role::Student),
            [
                new FileModel(1, 'name1', 'path1'),
                new FileModel(2, 'name2', 'path2'),
            ],
        );

        $mockRepo = $this->getMockBuilder('App\Domain\Repository\ISolutionRepository')
            ->onlyMethods(array('getAll', 'getById', 'create', 'update', 'delete'))
            ->getMock();
        $mockRepo
            ->expects($this->once())
            ->method('create')
            ->with($expected->getDescription(), $expected->getState(), $expected->getLabId(), $expected->getUser()->getId())
            ->willReturn($expected);

        $mockFIleRepo = $this->getMockBuilder('App\Domain\Repository\IFileRepository')
            ->onlyMethods(array('getAll', 'getById', 'createForLab', 'createForSolution', 'update', 'delete', 'deleteByLabID', 'deleteBySolutionID'))
            ->getMock();

        $mockStorage = $this->getMockBuilder('App\Domain\Storage\ISolutionFileStorage')
            ->onlyMethods(array('save', 'clearSolutionFiles'))
            ->getMock();

        $service = new SolutionService($mockRepo, $mockFIleRepo, $mockStorage);

        $actual = $service->create($expected->getDescription(), $expected->getState(), $expected->getLabId(), $expected->getUser()->getId());

        $this->assertSame($expected->getId(), $actual);
    }

    public function testGetAll(): void
    {
        $expected = [new SolutionModel(
            1,
            'desc',
            SolutionState::Checking,
            1,
            new UserModel(1, 'name1', 'login1', 'pass1', Role::Student),
            [
                new FileModel(1, 'name1', 'path1'),
                new FileModel(2, 'name2', 'path2'),
            ],
        )];

        $mockRepo = $this->getMockBuilder('App\Domain\Repository\ISolutionRepository')
            ->onlyMethods(array('getAll', 'getById', 'create', 'update', 'delete'))
            ->getMock();
        $mockRepo
            ->expects($this->once())
            ->method('getAll')
            ->willReturn($expected);

        $mockFIleRepo = $this->getMockBuilder('App\Domain\Repository\IFileRepository')
            ->onlyMethods(array('getAll', 'getById', 'createForLab', 'createForSolution', 'update', 'delete', 'deleteByLabID', 'deleteBySolutionID'))
            ->getMock();

        $mockStorage = $this->getMockBuilder('App\Domain\Storage\ISolutionFileStorage')
            ->onlyMethods(array('save', 'clearSolutionFiles'))
            ->getMock();

        $service = new SolutionService($mockRepo, $mockFIleRepo, $mockStorage);

        $actual = $service->getAll();

        $this->assertSame($expected, $actual);
    }

    public function testGet(): void
    {
        $expected = new SolutionModel(
            1,
            'desc',
            SolutionState::Checking,
            1,
            new UserModel(1, 'name1', 'login1', 'pass1', Role::Student),
            [
                new FileModel(1, 'name1', 'path1'),
                new FileModel(2, 'name2', 'path2'),
            ],
        );

        $mockRepo = $this->getMockBuilder('App\Domain\Repository\ISolutionRepository')
            ->onlyMethods(array('getAll', 'getById', 'create', 'update', 'delete'))
            ->getMock();
        $mockRepo
            ->expects($this->once())
            ->method('getById')
            ->with(1)
            ->willReturn($expected);

        $mockFIleRepo = $this->getMockBuilder('App\Domain\Repository\IFileRepository')
            ->onlyMethods(array('getAll', 'getById', 'createForLab', 'createForSolution', 'update', 'delete', 'deleteByLabID', 'deleteBySolutionID'))
            ->getMock();

        $mockStorage = $this->getMockBuilder('App\Domain\Storage\ISolutionFileStorage')
            ->onlyMethods(array('save', 'clearSolutionFiles'))
            ->getMock();

        $service = new SolutionService($mockRepo, $mockFIleRepo, $mockStorage);

        $actual = $service->get(1);

        $this->assertSame($expected, $actual);
    }

    public function testDelete(): void
    {
        $mockRepo = $this->getMockBuilder('App\Domain\Repository\ISolutionRepository')
            ->onlyMethods(array('getAll', 'getById', 'create', 'update', 'delete'))
            ->getMock();
        $mockRepo
            ->expects($this->once())
            ->method('delete')
            ->with(1);

        $mockFIleRepo = $this->getMockBuilder('App\Domain\Repository\IFileRepository')
            ->onlyMethods(array('getAll', 'getById', 'createForLab', 'createForSolution', 'update', 'delete', 'deleteByLabID', 'deleteBySolutionID'))
            ->getMock();

        $mockStorage = $this->getMockBuilder('App\Domain\Storage\ISolutionFileStorage')
            ->onlyMethods(array('save', 'clearSolutionFiles'))
            ->getMock();

        $service = new SolutionService($mockRepo, $mockFIleRepo, $mockStorage);

        $service->delete(1);
    }

    public function testUpdate(): void
    {
        $model = new SolutionModel(
            1,
            'desc',
            SolutionState::Checking,
            1,
            new UserModel(1, 'name1', 'login1', 'pass1', Role::Student),
            [
                new FileModel(1, 'name1', 'path1'),
                new FileModel(2, 'name2', 'path2'),
            ],
        );

        $mockRepo = $this->getMockBuilder('App\Domain\Repository\ISolutionRepository')
            ->onlyMethods(array('getAll', 'getById', 'create', 'update', 'delete'))
            ->getMock();
        $mockRepo
            ->expects($this->once())
            ->method('update')
            ->with(1, 'desc', SolutionState::Checking);

        $mockFIleRepo = $this->getMockBuilder('App\Domain\Repository\IFileRepository')
            ->onlyMethods(array('getAll', 'getById', 'createForLab', 'createForSolution', 'update', 'delete', 'deleteByLabID', 'deleteBySolutionID'))
            ->getMock();

        $mockStorage = $this->getMockBuilder('App\Domain\Storage\ISolutionFileStorage')
            ->onlyMethods(array('save', 'clearSolutionFiles'))
            ->getMock();

        $service = new SolutionService($mockRepo, $mockFIleRepo, $mockStorage);

        $service->update(1,'desc', SolutionState::Checking);
    }

    public function testUpdateFiles(): void
    {
        $files = [new FileModel(1, 'name1', 'path1')];
        $model = new SolutionModel(
            1,
            'desc',
            SolutionState::Checking,
            1,
            new UserModel(1, 'name1', 'login1', 'pass1', Role::Student),
            $files,
        );

        $mockRepo = $this->getMockBuilder('App\Domain\Repository\ISolutionRepository')
            ->onlyMethods(array('getAll', 'getById', 'create', 'update', 'delete'))
            ->getMock();
        $mockRepo
            ->expects($this->once())
            ->method('getById')
            ->with($model->getId())
            ->willReturn($model);

        $constPath = "pathcnst";
        $mockFIleRepo = $this->getMockBuilder('App\Domain\Repository\IFileRepository')
            ->onlyMethods(array('getAll', 'getById', 'createForLab', 'createForSolution', 'update', 'delete', 'deleteByLabID', 'deleteBySolutionID'))
            ->getMock();
        $mockFIleRepo
            ->expects($this->once())
            ->method('deleteBySolutionID')
            ->with($model->getId());
        $mockFIleRepo
            ->expects($this->once())
            ->method('createForSolution')
            ->with($constPath, $files[0]->getName(), $model->getId())
            ->willReturn($files[0]);

        $mockStorage = $this->getMockBuilder('App\Domain\Storage\ISolutionFileStorage')
            ->onlyMethods(array('save', 'clearSolutionFiles'))
            ->getMock();
        $mockStorage
            ->expects($this->once())
            ->method('clearSolutionFiles')
            ->with($model->getLabId(), $model->getId());
        $mockStorage
            ->expects($this->once())
            ->method('save')
            ->with($model->getLabId(), $model->getId(), $files[0])
            ->willReturn($constPath);

        $service = new SolutionService($mockRepo, $mockFIleRepo, $mockStorage);

        $service->updateFiles($model->getId(), $files);
    }
}