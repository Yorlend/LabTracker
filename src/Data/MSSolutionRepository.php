<?php 

namespace App\Data;

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
        $sol->setLabId($lab);
        $usr = $this->entityManager->getRepository(User::class)->find($labId);
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
        $sol->setDescription($description);
        $sol->setState($state->value);

        $this->entityManager->flush();
    }

    public function delete(int $id): void
    {
        $user = $this->entityManager->getRepository(Solution::class)->find($id);
        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }

    public function getAll(?int $labId, ?SolutionState $state): array
    {
        return $this->entityManager->getRepository(Solution::class)->findBy(
            ['lab_id' == $labId],
            ['state' == $state]
        );
    }

    public function getById(int $id): SolutionModel
    {
        $sol = $this->entityManager->getRepository(Solution::class)->findOneBy(
            ['id' == $id]
        );

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
}