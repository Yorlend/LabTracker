<?php

namespace App\Tests\Domain\Service;

use App\Domain\Model\Role;
use App\Domain\Model\UserModel;
use App\Domain\Service\UserService;
use PHPUnit\Framework\TestCase;

class UserServiceTest extends TestCase
{
    public function testCreate(): void
    {
        $expected = new UserModel(1, 'name1', 'login1', 'pass1', Role::Student);

        $mockRepo = $this->getMockBuilder('App\Domain\Repository\IUserRepository')
            ->onlyMethods(array('getAll', 'getById', 'create', 'update', 'delete'))
            ->getMock();
        $mockRepo
            ->expects($this->once())
            ->method('create')
            ->with($expected->getUserName(), $expected->getLogin(), $expected->getPassword(), $expected->getRole())
            ->willReturn($expected);

        $service = new UserService($mockRepo);

        $actual = $service->create($expected->getUserName(), $expected->getLogin(), $expected->getPassword(), $expected->getRole());

        $this->assertSame($expected->getId(), $actual);
    }

    public function testGetAll(): void
    {
        $expected = [
            new UserModel(1, 'name1', 'login1', 'pass1', Role::Student),
            new UserModel(2, 'name2', 'login2', 'pass2', Role::Student),
        ];

        $mockRepo = $this->getMockBuilder('App\Domain\Repository\IUserRepository')
            ->onlyMethods(array('getAll', 'getById', 'create', 'update', 'delete'))
            ->getMock();
        $mockRepo
            ->expects($this->once())
            ->method('getAll')
            ->willReturn($expected);

        $service = new UserService($mockRepo);

        $actual = $service->getAll();

        $this->assertSame($expected, $actual);
    }

    public function testGet(): void
    {
        $expected = new UserModel(1, 'name1', 'login1', 'pass1', Role::Student);

        $mockRepo = $this->getMockBuilder('App\Domain\Repository\IUserRepository')
            ->onlyMethods(array('getAll', 'getById', 'create', 'update', 'delete'))
            ->getMock();
        $mockRepo
            ->expects($this->once())
            ->method('getById')
            ->with(1)
            ->willReturn($expected);

        $service = new UserService($mockRepo);

        $actual = $service->get(1);

        $this->assertSame($expected, $actual);
    }

    public function testDelete(): void
    {
        $mockRepo = $this->getMockBuilder('App\Domain\Repository\IUserRepository')
            ->onlyMethods(array('getAll', 'getById', 'create', 'update', 'delete'))
            ->getMock();
        $mockRepo
            ->expects($this->once())
            ->method('delete')
            ->with(1);
        $service = new UserService($mockRepo);

        $service->delete(1);
    }

    public function testUpdate(): void
    {
        $model = new UserModel(1, 'name1', 'login1', 'pass1', Role::Student);

        $mockRepo = $this->getMockBuilder('App\Domain\Repository\IUserRepository')
            ->onlyMethods(array('getAll', 'getById', 'create', 'update', 'delete'))
            ->getMock();
        $mockRepo
            ->expects($this->once())
            ->method('update')
            ->with(1, $model);
        $service = new UserService($mockRepo);

        $service->update(1, $model);
    }
}