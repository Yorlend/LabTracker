<?php

namespace App\Data;

use App\Domain\Model\UserModel;
use App\Domain\Repository\ICommentRepository;
use App\Entity\Comment;
use App\Entity\Solution;
use App\Entity\User;
use App\Repository\CommentRepository;
use App\Domain\Model\CommentModel;
use App\Domain\Model\Role;
use Doctrine\ORM\EntityManagerInterface;

use DateTime;

class MSCommentRepository implements ICommentRepository
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function create(int $solutionId, string $text, int $userId): CommentModel
    {
        $comment = new Comment();

        $comment->setSolutionId($this->entityManager->getRepository(Solution::class)->findOneBy(['id' == $solutionId]));
        $comment->setText($text);
        $now = new DateTime("now");
        $comment->setData($now);
        $comment->setUserId($this->entityManager->getRepository(User::class)->findOneBy(['id' == $userId]));

        $this->entityManager->persist($comment);
        $this->entityManager->flush();

        return new CommentModel(
            $comment->getId(),
            $text,
            $now->format("Y M d H:i:s"),
            new UserModel(
                $comment->getUserId()->getId(),
                $comment->getUserId()->getUserName(),
                $comment->getUserId()->getLogin(),
                $comment->getUserId()->getPassword(),
                Role::from($comment->getUserId()->getRole())
            )
        );
    }

    public function getBySolutionId(int $solutionId): array
    {
        return $this->entityManager->getRepository(Comment::class)->findBy(
            ['solution_id' == $solutionId]
        );
    }

    public function update(int $id, string $text): void
    {
        $comment = $this->entityManager->getRepository(Comment::class)->find($id);
        $comment->setText($text);
        $this->entityManager->flush();
    }

    public function delete(int $id): void
    {
        $comment = $this->entityManager->getRepository(Comment::class)->find($id);
        $this->entityManager->remove($comment);
        $this->entityManager->flush();
    }
}