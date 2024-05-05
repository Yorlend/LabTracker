<?php 

namespace App\Data;

use App\Domain\Error\NotFoundError;
use App\Domain\Model\UserModel;
use App\Domain\Repository\ISolutionRepository;
use App\Domain\Model\SolutionModel;
use App\Domain\Model\SolutionState;
use App\Entity\Solution;
use App\Entity\Lab;
use App\Entity\User;
use App\Domain\Model\Role;
use Doctrine\ORM\EntityManagerInterface;

class MSSolutionRepository implements ISolutionRepository
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function create(string $description, SolutionState $state, int $labId, int $userId): SolutionModel
    {
        $sol = new Solution();

        $sol->setDescription($description);
        $sol->setState($state->value);
        $lab = $this->entityManager->getRepository(Lab::class)->find($labId);
        if ($lab == null) throw new NotFoundError("No lab with id {$labId}");
        $sol->setLabId($lab);
        $usr = $this->entityManager->getRepository(User::class)->find($labId);
        if ($usr == null) throw new NotFoundError("No user with id {$userId}");
        $sol->setUserId($usr);

        $this->entityManager->persist($sol);
        $this->entityManager->flush();

        return new SolutionModel(
            $sol->getId(),
            $description,
            $state,
            $labId,
            new UserModel(
                $userId,
                $usr->getUserName(),
                $usr->getLogin(),
                $usr->getPassword(),
                Role::from($usr->getRole())
            ), 
            array()
        );
    }

    public function update(int $id, string $description, SolutionState $state): void
    {
        $sol = $this->entityManager->getRepository(Solution::class)->find($id);
        if ($sol == null) throw new NotFoundError("No solution with id {$id}");
        $sol->setDescription($description);
        $sol->setState($state->value);

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
        if ($labId != null && $state != null)
            return $this->entityManager->getRepository(Solution::class)->findBy(
                ['lab_id' => $labId,
                'state' => $state]
            );
        else if ($labId != null && $state == null)
            return $this->entityManager->getRepository(Solution::class)->findBy(
                ['lab_id' => $labId]
            );
        else if ($labId == null && $state != null)
            return $this->entityManager->getRepository(Solution::class)->findBy(
                ['state' => $state]
            );
        return $this->entityManager->getRepository(Solution::class)->findAll();
    }

    public function getById(int $id): SolutionModel
    {
        $sol = $this->entityManager->getRepository(Solution::class)->findOneBy(
            ['id' => $id]
        );
        if ($sol == null) throw new NotFoundError("No solution with id {$id}");

        return new SolutionModel(
            $sol->getId(),
            $sol->getDescription(),
            SolutionState::from($sol->getState()),
            $sol->getLabId()->getId(),
            new UserModel(
                $sol->getUserId()->getId(),
                $sol->getUserId()->getUserName(),
                $sol->getUserId()->getLogin(),
                $sol->getUserId()->getPassword(),
                Role::from($sol->getUserId()->getRole())
            ),
            $sol->getFilesAdded()->getValues()
        );
    }

    /**
     * @throws NotFoundError
     */
    public function isOwner(int $userId, int $solId): bool
    {
        $sol = $this->entityManager->getRepository(Solution::class)->findOneBy(
            ['id' => $solId]
        );

        if ($sol == null) throw new NotFoundError("No solution with id {$solId}");

        return $userId == $sol->getUserId()->getId();
    }
}