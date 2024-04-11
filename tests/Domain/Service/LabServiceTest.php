<?php

namespace App\Tests\Domain\Service;

use App\Domain\Model\FileModel;
use App\Domain\Model\GroupModel;
use App\Domain\Model\LabModel;
use App\Domain\Model\Role;
use App\Domain\Model\UserModel;
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
            new GroupModel(
                1,
                [
                    new UserModel(1, 'name1', 'login1', 'pass1', Role::Student),
                    new UserModel(2, 'name2', 'login2', 'pass2', Role::Student),
                ],
                new UserModel(3, 'name3', 'login3', 'pass3', Role::Teacher),
            ),
            [
                new FileModel(1, 'name1', 'path1/name1'),
            ]
        );

        $mockRepo = $this->getMockBuilder('App\Domain\Repository\ILabRepository')
            ->onlyMethods(array('getAll', 'getById', 'create', 'update', 'delete'))
            ->getMock();
        $mockRepo
            ->expects($this->once())
            ->method('create')
            ->with($expected->getName(), $expected->getDescription(), $expected->getGroup()->getId())
            ->willReturn($expected);

        $mockFIleRepo = $this->getMockBuilder('App\Domain\Repository\IFileRepository')
            ->onlyMethods(array('getAll', 'getById', 'createForLab', 'createForSolution', 'update', 'delete', 'deleteByLabID', 'deleteBySolutionID'))
            ->getMock();
        $mockFIleRepo
            ->expects($this->once())
            ->method('createForLab')
            ->with($expected->getFiles()[0]->getName(), $expected->getFiles()[0]->getPath(), $expected->getId())
            ->willReturn($expected->getFiles()[0]);

        $mockStorage = $this->getMockBuilder('App\Domain\Storage\ILabFileStorage')
            ->onlyMethods(array('save', 'clearLabFiles'))
            ->getMock();
        $mockStorage
            ->expects($this->once())
            ->method('save')
            ->with($expected->getGroup()->getId(), $expected->getId(), $files);

        $service = new LabService($mockRepo, $mockFIleRepo, $mockStorage);

        $actual = $service->create($expected->getName(), $expected->getDescription(), $expected->getGroup()->getId(), $files);

        $this->assertSame($expected->getId(), $actual);
    }

    public function testGetAll(): void
    {
        $expected = [new LabModel(
            1,
            'name',
            'desc',
            new GroupModel(
                1,
                [
                    new UserModel(1, 'name1', 'login1', 'pass1', Role::Student),
                    new UserModel(2, 'name2', 'login2', 'pass2', Role::Student),
                ],
                new UserModel(3, 'name3', 'login3', 'pass3', Role::Teacher),
            ),
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
            ->onlyMethods(array('getAll', 'getById', 'createForLab', 'createForSolution', 'update', 'delete', 'deleteByLabID', 'deleteBySolutionID'))
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
            new GroupModel(
                1,
                [
                    new UserModel(1, 'name1', 'login1', 'pass1', Role::Student),
                    new UserModel(2, 'name2', 'login2', 'pass2', Role::Student),
                ],
                new UserModel(3, 'name3', 'login3', 'pass3', Role::Teacher),
            ),
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
            ->onlyMethods(array('getAll', 'getById', 'createForLab', 'createForSolution', 'update', 'delete', 'deleteByLabID', 'deleteBySolutionID'))
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
            ->onlyMethods(array('getAll', 'getById', 'createForLab', 'createForSolution', 'update', 'delete', 'deleteByLabID', 'deleteBySolutionID'))
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
            new GroupModel(
                1,
                [
                    new UserModel(1, 'name1', 'login1', 'pass1', Role::Student),
                    new UserModel(2, 'name2', 'login2', 'pass2', Role::Student),
                ],
                new UserModel(3, 'name3', 'login3', 'pass3', Role::Teacher),
            ),
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
            ->with(1, $model);

        $mockFIleRepo = $this->getMockBuilder('App\Domain\Repository\IFileRepository')
            ->onlyMethods(array('getAll', 'getById', 'createForLab', 'createForSolution', 'update', 'delete', 'deleteByLabID', 'deleteBySolutionID'))
            ->getMock();

        $mockStorage = $this->getMockBuilder('App\Domain\Storage\ILabFileStorage')
            ->onlyMethods(array('save', 'clearLabFiles'))
            ->getMock();

        $service = new LabService($mockRepo, $mockFIleRepo, $mockStorage);

        $service->update(1, $model);
    }

    public function testUpdateFiles(): void
    {
        $files = ['path1/name1'];
        $model = new LabModel(
            1,
            'name',
            'desc',
            new GroupModel(
                1,
                [
                    new UserModel(1, 'name1', 'login1', 'pass1', Role::Student),
                    new UserModel(2, 'name2', 'login2', 'pass2', Role::Student),
                ],
                new UserModel(3, 'name3', 'login3', 'pass3', Role::Teacher),
            ),
            [
                new FileModel(1, 'name1', 'path1/name1'),
            ]
        );

        $mockRepo = $this->getMockBuilder('App\Domain\Repository\ILabRepository')
            ->onlyMethods(array('getAll', 'getById', 'create', 'update', 'delete'))
            ->getMock();
        $mockRepo
            ->expects($this->once())
            ->method('getById')
            ->with($model->getId())
            ->willReturn($model);

        $mockFIleRepo = $this->getMockBuilder('App\Domain\Repository\IFileRepository')
            ->onlyMethods(array('getAll', 'getById', 'createForLab', 'createForSolution', 'update', 'delete', 'deleteByLabID', 'deleteBySolutionID'))
            ->getMock();
        $mockFIleRepo
            ->expects($this->once())
            ->method('deleteByLabID')
            ->with($model->getId());
        $mockFIleRepo
            ->expects($this->once())
            ->method('createForLab')
            ->with('name1', $files[0], $model->getId())
            ->willReturn($model->getFiles()[0]);

        $mockStorage = $this->getMockBuilder('App\Domain\Storage\ILabFileStorage')
            ->onlyMethods(array('save', 'clearLabFiles'))
            ->getMock();
        $mockStorage
            ->expects($this->once())
            ->method('clearLabFiles')
            ->with($model->getGroup()->getId(), $model->getId());
        $mockStorage
            ->expects($this->once())
            ->method('save')
            ->with($model->getGroup()->getId(), $model->getId(), $files);

        $service = new LabService($mockRepo, $mockFIleRepo, $mockStorage);

        $service->updateFiles($model->getId(), $files);
    }
}