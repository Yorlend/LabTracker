<?php

namespace App\DA\Repository;

use App\DA\Entity\Comment;
use App\DA\Entity\Solution;
use App\DA\Entity\User;
use App\Domain\Error\NotFoundError;
use App\Domain\Model\CommentModel;
use App\Domain\Model\Role;
use App\Domain\Model\UserModel;
use App\Domain\Repository\ICommentRepository;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class MSCommentRepository extends ServiceEntityRepository implements ICommentRepository
{
    public function __construct(
        private EntityManagerInterface $entityManager, ManagerRegistry $registry
    )
    {
        parent::__construct($registry, Comment::class);
    }

    public function create(int $solutionId, string $text, int $userId): CommentModel
    {
        $comment = new Comment();

        $sol = $this->entityManager->getRepository(Solution::class)->find($solutionId);
        if ($sol == null) throw new NotFoundError("No solution with id {$solutionId}");
        $user = $this->entityManager->getRepository(User::class)->find($userId);
        if ($user == null) throw new NotFoundError("No user with id {$userId}");
        $now = new DateTime("now");


        $comment->solution = $sol;
        $comment->text = $text;
        $comment->data = $now;
        $comment->user = $user;

        $this->entityManager->persist($comment);
        $this->entityManager->flush();

        return new CommentModel(
            $comment->id,
            $text,
            $now->format("Y M d H:i:s"),
            new UserModel(
                $user->id,
                $user->user_name,
                $user->login,
                $user->password,
                Role::from($user->role)
            )
        );
    }

    public function getBySolutionId(int $solutionId): array
    {
        $sol = $this->entityManager->getRepository(Solution::class)->find($solutionId);
        if ($sol == null) throw new NotFoundError("No solution with id {$solutionId}");

        $data = $this->entityManager->getRepository(Comment::class)->findBy(
            ['solution' => $sol]);

        $res = [];
        foreach ($data as $comment) {
            $res[] = new CommentModel(
                $comment->id,
                $comment->text,
                $comment->data->format("Y M d H:i:s"),
                new UserModel(
                    $comment->user->id,
                    $comment->user->user_name,
                    $comment->user->login,
                    $comment->user->password,
                    Role::from($comment->user->role)
                )
            );
        }

        return $res;
    }

    public function update(int $id, string $text): void
    {
        $comment = $this->entityManager->getRepository(Comment::class)->find($id);
        if ($comment == null) throw new NotFoundError("No comment with id {$id}");
        $comment->text = $text;

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
        $comment = $this->entityManager->getRepository(Comment::class)->findOneBy(
            ['id' => $commentId]
        );
        if ($comment == null) throw new NotFoundError("No comment with id {$commentId}");

        return $userId == $comment->user->id;
    }
}