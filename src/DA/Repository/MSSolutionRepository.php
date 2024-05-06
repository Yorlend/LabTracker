<?php

namespace App\DA\Repository;

use App\DA\Entity\Comment;
use App\DA\Entity\Lab;
use App\DA\Entity\Solution;
use App\DA\Entity\User;
use App\Domain\Error\NotFoundError;
use App\Domain\Model\FileModel;
use App\Domain\Model\LabModel;
use App\Domain\Model\Role;
use App\Domain\Model\SolutionModel;
use App\Domain\Model\SolutionState;
use App\Domain\Model\UserModel;
use App\Domain\Repository\ISolutionRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class MSSolutionRepository extends ServiceEntityRepository implements ISolutionRepository
{
    public function __construct(
        private EntityManagerInterface $entityManager, ManagerRegistry $registry
    )
    {
        parent::__construct($registry, Comment::class);
    }

    public function create(string $description, SolutionState $state, int $labId, int $userId): SolutionModel
    {
        $sol = new Solution();

        $lab = $this->entityManager->getRepository(Lab::class)->find($labId);
        if ($lab == null) throw new NotFoundError("No lab with id {$labId}");
        $user = $this->entityManager->getRepository(User::class)->find($userId);
        if ($user == null) throw new NotFoundError("No user with id {$userId}");

        $sol->description = $description;
        $sol->state = $state->value;
        $sol->lab = $lab;
        $sol->user = $user;

        $this->entityManager->persist($sol);
        $this->entityManager->flush();

        return new SolutionModel(
            $sol->id,
            $description,
            $state,
            $labId,
            new UserModel(
                $user->id,
                $user->user_name,
                $user->login,
                $user->password,
                Role::from($user->role)
            ),
            array()
        );
    }

    public function update(int $id, string $description, SolutionState $state): void
    {
        $sol = $this->entityManager->getRepository(Solution::class)->find($id);
        if ($sol == null) throw new NotFoundError("No solution with id {$id}");

        $sol->description = $description;
        $sol->state = $state->value;

        $this->entityManager->flush();
    }

    public function delete(int $id): void
    {
        $sol = $this->entityManager->getRepository(Solution::class)->find($id);
        if ($sol == null) throw new NotFoundError("No solution with id {$id}");

        $this->entityManager->remove($sol);
        $this->entityManager->flush();
    }

    public function getAll(?int $labId, ?SolutionState $state): array
    {
        $criteria = [];
        if ($labId != null) {
            $criteria[] = ['lab_id' => $labId];
        }
        if ($state != null) {
            $criteria[] = ['state' => $state->value];
        }

        $data = $this->entityManager->getRepository(Solution::class)->findBy(
            $criteria
        );

        $res = [];
        foreach ($data as $sol) {
            $files = [];
            foreach ($sol->files as $file) {
                $files[] = new FileModel(
                    $file->id,
                    $file->name,
                    $file->path,
                    null,
                    $file->solution->id
                );
            }

            $res[] = new SolutionModel(
                $sol->id,
                $sol->description,
                SolutionState::from($sol->state),
                $sol->lab->id,
                new UserModel(
                    $sol->user->id,
                    $sol->user->user_name,
                    $sol->user->login,
                    $sol->user->password,
                    Role::from($sol->user->role)
                ),
                $files
            );
        }

        return $res;


    }

    public function getById(int $id): SolutionModel
    {
        $sol = $this->entityManager->getRepository(Solution::class)->find($id);
        if ($sol == null) throw new NotFoundError("No solution with id {$id}");

        $files = [];
        foreach ($sol->files as $file) {
            $files[] = new FileModel(
                $file->id,
                $file->name,
                $file->path,
                null,
                $file->solution->id
            );
        }

        return new SolutionModel(
            $sol->id,
            $sol->description,
            SolutionState::from($sol->state),
            $sol->lab->id,
            new UserModel(
                $sol->user->id,
                $sol->user->user_name,
                $sol->user->login,
                $sol->user->password,
                Role::from($sol->user->role)
            ),
            $files
        );
    }

    /**
     * @throws NotFoundError
     */
    public function isOwner(int $userId, int $solId): bool
    {
        $sol = $this->entityManager->getRepository(Solution::class)->find($solId);
        if ($sol == null) throw new NotFoundError("No solution with id {$solId}");

        return $userId == $sol->user->id;
    }
}