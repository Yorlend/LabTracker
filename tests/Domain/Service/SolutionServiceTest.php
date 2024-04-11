<?php

namespace App\Tests\Domain\Service;

use App\Domain\Model\CommentModel;
use App\Domain\Model\FileModel;
use App\Domain\Model\GroupModel;
use App\Domain\Model\LabModel;
use App\Domain\Model\LabState;
use App\Domain\Model\Role;
use App\Domain\Model\SolutionModel;
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
            LabState::Checking,
            new LabModel(
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
                    new FileModel(1, 'name1')
                ]),
            new UserModel(1, 'name1', 'login1', 'pass1', Role::Student),
            [
                new FileModel(1, 'name1'),
                new FileModel(2, 'name2'),
            ],
            [
                new CommentModel(
                    1,
                    'text',
                    'now',
                    new UserModel(1, 'name', 'login', 'pass', Role::Administrator)
                )
            ]
        );

        $mockRepo = $this->getMockBuilder('App\Domain\Repository\ISolutionRepository')
            ->onlyMethods(array('getAll', 'getById', 'create', 'update', 'delete'))
            ->getMock();
        $mockRepo
            ->expects($this->once())
            ->method('create')
            ->with($expected->getDescription(), $expected->getState(), $expected->getLab()->getId(), $expected->getUser()->getId())
            ->willReturn($expected);

        $mockFIleRepo = $this->getMockBuilder('App\Domain\Repository\IFileRepository')
            ->onlyMethods(array('getAll', 'getById', 'createForLab', 'createForSolution', 'update', 'delete', 'deleteByLabID', 'deleteBySolutionID'))
            ->getMock();
        $mockFIleRepo
            ->expects($this->once())
            ->method('createForSolution')
            ->with('name1', $expected->getId())
            ->willReturn($expected->getFiles()[0]);

        $mockStorage = $this->getMockBuilder('App\Domain\Storage\ISolutionFileStorage')
            ->onlyMethods(array('save', 'clearSolutionFiles', 'getFilePath'))
            ->getMock();
        $mockStorage
            ->expects($this->once())
            ->method('save')
            ->with($expected->getLab()->getId(), $expected->getId(), $files);

        $service = new SolutionService($mockRepo, $mockFIleRepo, $mockStorage);

        $actual = $service->create($expected->getDescription(), $expected->getState(), $expected->getLab()->getId(), $expected->getUser()->getId(), $files);

        $this->assertSame($expected->getId(), $actual);
    }

    public function testGetAll(): void
    {
        $expected = [new SolutionModel(
            1,
            'desc',
            LabState::Checking,
            new LabModel(
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
                    new FileModel(1, 'name1'),
                    new FileModel(2, 'name2'),
                ]),
            new UserModel(1, 'name1', 'login1', 'pass1', Role::Student),
            [
                new FileModel(1, 'name1'),
                new FileModel(2, 'name2'),
            ],
            [
                new CommentModel(
                    1,
                    'text',
                    'now',
                    new UserModel(1, 'name', 'login', 'pass', Role::Administrator)
                )
            ]
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
            ->onlyMethods(array('save', 'clearSolutionFiles', 'getFilePath'))
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
            LabState::Checking,
            new LabModel(
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
                    new FileModel(1, 'name1'),
                    new FileModel(2, 'name2'),
                ]),
            new UserModel(1, 'name1', 'login1', 'pass1', Role::Student),
            [
                new FileModel(1, 'name1'),
                new FileModel(2, 'name2'),
            ],
            [
                new CommentModel(
                    1,
                    'text',
                    'now',
                    new UserModel(1, 'name', 'login', 'pass', Role::Administrator)
                )
            ]
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
            ->onlyMethods(array('save', 'clearSolutionFiles', 'getFilePath'))
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
            ->onlyMethods(array('save', 'clearSolutionFiles', 'getFilePath'))
            ->getMock();

        $service = new SolutionService($mockRepo, $mockFIleRepo, $mockStorage);

        $service->delete(1);
    }

    public function testUpdate(): void
    {
        $model = new SolutionModel(
            1,
            'desc',
            LabState::Checking,
            new LabModel(
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
                    new FileModel(1, 'name1'),
                    new FileModel(2, 'name2'),
                ]),
            new UserModel(1, 'name1', 'login1', 'pass1', Role::Student),
            [
                new FileModel(1, 'name1'),
                new FileModel(2, 'name2'),
            ],
            [
                new CommentModel(
                    1,
                    'text',
                    'now',
                    new UserModel(1, 'name', 'login', 'pass', Role::Administrator)
                )
            ]
        );

        $mockRepo = $this->getMockBuilder('App\Domain\Repository\ISolutionRepository')
            ->onlyMethods(array('getAll', 'getById', 'create', 'update', 'delete'))
            ->getMock();
        $mockRepo
            ->expects($this->once())
            ->method('update')
            ->with(1, $model);

        $mockFIleRepo = $this->getMockBuilder('App\Domain\Repository\IFileRepository')
            ->onlyMethods(array('getAll', 'getById', 'createForLab', 'createForSolution', 'update', 'delete', 'deleteByLabID', 'deleteBySolutionID'))
            ->getMock();

        $mockStorage = $this->getMockBuilder('App\Domain\Storage\ISolutionFileStorage')
            ->onlyMethods(array('save', 'clearSolutionFiles', 'getFilePath'))
            ->getMock();

        $service = new SolutionService($mockRepo, $mockFIleRepo, $mockStorage);

        $service->update(1, $model);
    }

    public function testUpdateFiles(): void
    {
        $files = ['path1/name1'];
        $model = new SolutionModel(
            1,
            'desc',
            LabState::Checking,
            new LabModel(
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
                    new FileModel(1, 'name1')
                ]),
            new UserModel(1, 'name1', 'login1', 'pass1', Role::Student),
            [
                new FileModel(1, 'name1'),
                new FileModel(2, 'name2'),
            ],
            [
                new CommentModel(
                    1,
                    'text',
                    'now',
                    new UserModel(1, 'name', 'login', 'pass', Role::Administrator)
                )
            ]
        );

        $mockRepo = $this->getMockBuilder('App\Domain\Repository\ISolutionRepository')
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
            ->method('deleteBySolutionID')
            ->with($model->getId());
        $mockFIleRepo
            ->expects($this->once())
            ->method('createForSolution')
            ->with('name1', $model->getId())
            ->willReturn($model->getFiles()[0]);

        $mockStorage = $this->getMockBuilder('App\Domain\Storage\ISolutionFileStorage')
            ->onlyMethods(array('save', 'clearSolutionFiles', 'getFilePath'))
            ->getMock();
        $mockStorage
            ->expects($this->once())
            ->method('clearSolutionFiles')
            ->with($model->getLab()->getId(), $model->getId());
        $mockStorage
            ->expects($this->once())
            ->method('save')
            ->with($model->getLab()->getId(), $model->getId(), $files);

        $service = new SolutionService($mockRepo, $mockFIleRepo, $mockStorage);

        $service->updateFiles($model->getId(), $files);
    }

    public function testGetFiles(): void
    {
        $model = new SolutionModel(
            1,
            'desc',
            LabState::Checking,
            new LabModel(
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
                    new FileModel(1, 'name1'),
                    new FileModel(2, 'name2'),
                ]),
            new UserModel(1, 'name1', 'login1', 'pass1', Role::Student),
            [
                new FileModel(1, 'name1'),
                new FileModel(2, 'name2'),
            ],
            [
                new CommentModel(
                    1,
                    'text',
                    'now',
                    new UserModel(1, 'name', 'login', 'pass', Role::Administrator)
                )
            ]
        );
        $expected = 'path';

        $mockRepo = $this->getMockBuilder('App\Domain\Repository\ISolutionRepository')
            ->onlyMethods(array('getAll', 'getById', 'create', 'update', 'delete'))
            ->getMock();
        $mockRepo
            ->expects($this->once())
            ->method('getById')
            ->with(1)
            ->willReturn($model);

        $mockFIleRepo = $this->getMockBuilder('App\Domain\Repository\IFileRepository')
            ->onlyMethods(array('getAll', 'getById', 'createForLab', 'createForSolution', 'update', 'delete', 'deleteByLabID', 'deleteBySolutionID'))
            ->getMock();

        $mockStorage = $this->getMockBuilder('App\Domain\Storage\ISolutionFileStorage')
            ->onlyMethods(array('save', 'clearSolutionFiles', 'getFilePath'))
            ->getMock();
        $mockStorage
            ->expects($this->once())
            ->method('getFilePath')
            ->with($model->getLab()->getId(), $model->getId(), $model->getFiles()[0]->getName())
            ->willReturn($expected);

        $service = new SolutionService($mockRepo, $mockFIleRepo, $mockStorage);

        $actual = $service->getFile($model->getId(), $model->getFiles()[0]->getName());

        $this->assertSame($expected, $actual);
    }
}