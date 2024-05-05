<?php

namespace App\Data;

use App\Domain\Error\NotFoundError;
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

        $sol = $this->entityManager->getRepository(Solution::class)->findOneBy(['id' == $solutionId]);
        if ($sol == null) throw new NotFoundError("No solution with id {$solutionId}");
        $comment->setSolutionId($sol);
        
        $comment->setText($text);
        $now = new DateTime("now");
        $comment->setData($now);
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['id' == $userId]);
        if ($user == null) throw new NotFoundError("No user with id {$userId}");
        $comment->setUserId($user);

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
            ['solution_id' => $solutionId]);
    }

    public function update(int $id, string $text): void
    {
        $comment = $this->entityManager->getRepository(Comment::class)->find($id);
        if ($comment == null) throw new NotFoundError("No comment with id {$id}");
        $comment->setText($text);
        $this->entityManager->flush();
    }

    public function delete(int $id): void
    {
        $comment = $this->entityManager->getRepository(Comment::class)->find($id);
        if ($comment == null) throw new NotFoundError("No comment with id {$id}");
        $this->entityManager->remove($comment);
        $this->entityManager->flush();
    }

    /**
     * @throws NotFoundError
     */
    public function isOwner(int $userId, int $commentId): bool
    {
        $comment = $this->entityManager->getRepository(Solution::class)->findOneBy(
            ['id' => $commentId]
        );

        if ($comment == null) throw new NotFoundError("No comment with id {$commentId}");

        return $userId == $comment->getUserId()->getId();
    }
}