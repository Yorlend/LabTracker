<?php

namespace App\Tests\Domain\Service;

use App\Domain\Model\GroupModel;
use App\Domain\Model\Role;
use App\Domain\Model\UserModel;
use App\Domain\Service\GroupService;
use PHPUnit\Framework\TestCase;

class GroupServiceTest extends TestCase
{
    public function testCreate(): void
    {
        $expected = new GroupModel(
            1,
            [
                new UserModel(1, 'name1', 'login1', 'pass1', Role::Student),
                new UserModel(2, 'name2', 'login2', 'pass2', Role::Student),
            ],
            new UserModel(3, 'name3', 'login3', 'pass3', Role::Teacher),
        );

        $mockRepo = $this->getMockBuilder('App\Domain\Repository\IGroupRepository')
            ->onlyMethods(array('getAll', 'getById', 'create', 'update', 'delete', 'addUsers', 'deleteUsers', 'addLab', 'deleteLab'))
            ->getMock();
        $mockRepo
            ->expects($this->once())
            ->method('create')
            ->with([1, 2], 3)
            ->willReturn($expected);
        $service = new GroupService($mockRepo);

        $actual = $service->create([1, 2], 3);

        $this->assertSame($expected->getId(), $actual);
    }

    public function testGetAll(): void
    {
        $expected = [new GroupModel(
            1,
            [
                new UserModel(1, 'name1', 'login1', 'pass1', Role::Student),
                new UserModel(2, 'name2', 'login2', 'pass2', Role::Student),
            ],
            new UserModel(3, 'name3', 'login3', 'pass3', Role::Teacher),
        )];

        $mockRepo = $this->getMockBuilder('App\Domain\Repository\IGroupRepository')
            ->onlyMethods(array('getAll', 'getById', 'create', 'update', 'delete', 'addUsers', 'deleteUsers', 'addLab', 'deleteLab'))
            ->getMock();
        $mockRepo
            ->expects($this->once())
            ->method('getAll')
            ->willReturn($expected);
        $service = new GroupService($mockRepo);

        $actual = $service->getAll();

        $this->assertSame($expected, $actual);
    }

    public function testGet(): void
    {
        $expected = new GroupModel(
            1,
            [
                new UserModel(1, 'name1', 'login1', 'pass1', Role::Student),
                new UserModel(2, 'name2', 'login2', 'pass2', Role::Student),
            ],
            new UserModel(3, 'name3', 'login3', 'pass3', Role::Teacher),
        );

        $mockRepo = $this->getMockBuilder('App\Domain\Repository\IGroupRepository')
            ->onlyMethods(array('getAll', 'getById', 'create', 'update', 'delete', 'addUsers', 'deleteUsers', 'addLab', 'deleteLab'))
            ->getMock();
        $mockRepo
            ->expects($this->once())
            ->method('getById')
            ->with(1)
            ->willReturn($expected);
        $service = new GroupService($mockRepo);

        $actual = $service->get(1);

        $this->assertSame($expected, $actual);
    }

    public function testDelete(): void
    {
        $mockRepo = $this->getMockBuilder('App\Domain\Repository\IGroupRepository')
            ->onlyMethods(array('getAll', 'getById', 'create', 'update', 'delete', 'addUsers', 'deleteUsers', 'addLab', 'deleteLab'))
            ->getMock();
        $mockRepo
            ->expects($this->once())
            ->method('delete')
            ->with(1);
        $service = new GroupService($mockRepo);

        $service->delete(1);
    }

    public function testUpdate(): void
    {
        $model = new GroupModel(
            1,
            [
                new UserModel(1, 'name1', 'login1', 'pass1', Role::Student),
                new UserModel(2, 'name2', 'login2', 'pass2', Role::Student),
            ],
            new UserModel(3, 'name3', 'login3', 'pass3', Role::Teacher),
        );

        $mockRepo = $this->getMockBuilder('App\Domain\Repository\IGroupRepository')
            ->onlyMethods(array('getAll', 'getById', 'create', 'update', 'delete', 'addUsers', 'deleteUsers', 'addLab', 'deleteLab'))
            ->getMock();
        $mockRepo
            ->expects($this->once())
            ->method('update')
            ->with(1, $model);
        $service = new GroupService($mockRepo);

        $service->update(1, $model);
    }

    public function testAddUsers(): void
    {
        $mockRepo = $this->getMockBuilder('App\Domain\Repository\IGroupRepository')
            ->onlyMethods(array('getAll', 'getById', 'create', 'update', 'delete', 'addUsers', 'deleteUsers', 'addLab', 'deleteLab'))
            ->getMock();
        $mockRepo
            ->expects($this->once())
            ->method('addUsers')
            ->with(1, [2, 3]);
        $service = new GroupService($mockRepo);

        $service->addUsers(1, [2, 3]);
    }

    public function testDeleteUsers(): void
    {
        $mockRepo = $this->getMockBuilder('App\Domain\Repository\IGroupRepository')
            ->onlyMethods(array('getAll', 'getById', 'create', 'update', 'delete', 'addUsers', 'deleteUsers', 'addLab', 'deleteLab'))
            ->getMock();
        $mockRepo
            ->expects($this->once())
            ->method('deleteUsers')
            ->with(1, [2, 3]);
        $service = new GroupService($mockRepo);

        $service->deleteUsers(1, [2, 3]);
    }

    public function testAddLab(): void
    {
        $mockRepo = $this->getMockBuilder('App\Domain\Repository\IGroupRepository')
            ->onlyMethods(array('getAll', 'getById', 'create', 'update', 'delete', 'addUsers', 'deleteUsers', 'addLab', 'deleteLab'))
            ->getMock();
        $mockRepo
            ->expects($this->once())
            ->method('addLab')
            ->with(1, 2);
        $service = new GroupService($mockRepo);

        $service->addLab(1, 2);
    }

    public function testDeleteLab(): void
    {
        $mockRepo = $this->getMockBuilder('App\Domain\Repository\IGroupRepository')
            ->onlyMethods(array('getAll', 'getById', 'create', 'update', 'delete', 'addUsers', 'deleteUsers', 'addLab', 'deleteLab'))
            ->getMock();
        $mockRepo
            ->expects($this->once())
            ->method('deleteLab')
            ->with(1, 2);
        $service = new GroupService($mockRepo);

        $service->deleteLab(1, 2);
    }
}