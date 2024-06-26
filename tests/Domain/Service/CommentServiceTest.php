<?php

namespace App\Tests\Domain\Service;

use App\Domain\Model\CommentModel;
use App\Domain\Model\Role;
use App\Domain\Model\UserModel;
use App\Domain\Service\CommentService;
use PHPUnit\Framework\TestCase;

class CommentServiceTest extends TestCase
{
    public function testCreate(): void
    {
        $mockRepo = $this->getMockBuilder('App\Domain\Repository\ICommentRepository')
            ->onlyMethods(array('create', 'update', 'delete', 'getBySolutionId', 'isOwner'))
            ->getMock();
        $mockRepo
            ->expects($this->once())
            ->method('create')
            ->with(1, 'text')
            ->willReturn(new CommentModel(
                1,
                'text',
                'now',
                new UserModel(1, 'name', 'login', 'pass', Role::Administrator)
            ));
        $service = new CommentService($mockRepo);
        $expected = 1;

        $actual = $service->create(1, 'text', 1);

        $this->assertSame($expected, $actual);
    }

    public function testGetBySolutionId(): void
    {
        $expected = [
            new CommentModel(
                1,
                'text',
                'now',
                new UserModel(1, 'name', 'login', 'pass', Role::Administrator)
            )
        ];

        $mockRepo = $this->getMockBuilder('App\Domain\Repository\ICommentRepository')
            ->onlyMethods(array('create', 'update', 'delete', 'getBySolutionId', 'isOwner'))
            ->getMock();
        $mockRepo
            ->expects($this->once())
            ->method('getBySolutionId')
            ->with(1)
            ->willReturn($expected);
        $service = new CommentService($mockRepo);

        $actual = $service->getBySolutionId(1);

        $this->assertSame($expected, $actual);
    }

    public function testDelete(): void
    {
        $mockRepo = $this->getMockBuilder('App\Domain\Repository\ICommentRepository')
            ->onlyMethods(array('create', 'update', 'delete', 'getBySolutionId', 'isOwner'))
            ->getMock();
        $mockRepo
            ->expects($this->once())
            ->method('delete')
            ->with(1);
        $service = new CommentService($mockRepo);

        $service->delete(1);
    }

    public function testUpdate(): void
    {
        $model = new CommentModel(
            1,
            'text',
            'now',
            new UserModel(1, 'name', 'login', 'pass', Role::Administrator)
        );
        $mockRepo = $this->getMockBuilder('App\Domain\Repository\ICommentRepository')
            ->onlyMethods(array('create', 'update', 'delete', 'getBySolutionId', 'isOwner'))
            ->getMock();
        $mockRepo
            ->expects($this->once())
            ->method('update')
            ->with(1, 'text');
        $service = new CommentService($mockRepo);

        $service->update(1, 'text');
    }
}