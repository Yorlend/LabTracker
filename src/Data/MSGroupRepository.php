<?php 

namespace App\Data;

use App\Domain\Error\NotFoundError;
use App\Domain\Model\GroupModel;
use App\Domain\Model\LabModel;
use App\Domain\Repository\IGroupRepository;
use App\Entity\Lab;
use App\Entity\Group;
use App\Entity\User;
use App\Entity\UserGroup;
use Doctrine\ORM\EntityManagerInterface;

class MSGroupRepository implements IGroupRepository
    {public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function create(string $name, array $users, int $teacherId): GroupModel
    {
        $group = new Group();
        $usgr = new UserGroup();

        $group->setName($name);
        $teach = $this->entityManager->getRepository(User::class)->find($teacherId);
        if ($teach == null) throw new NotFoundError("No user with id {$teacherId}");
        $group->setTeacherId($teach);
        
        foreach ($users as &$usr)
            if ($this->entityManager->getRepository(User::class)->find($usr))
                $usgr->addUserId($this->entityManager->getRepository(User::class)->find($usr));
        
        $group->setGroupMatch($usgr);

        $this->entityManager->persist($group);
        $this->entityManager->flush();

        $usgr->setGroupId($group);
        $this->entityManager->persist($usgr);
        $this->entityManager->flush();

        return new GroupModel(
            $group->getId(),
            $name,
            $users,
            $teacherId
        );
    }

    public function update(int $id, string $name, int $teacherId): void
    {
        $group = $this->entityManager->getRepository(Group::class)->find($id);
        if ($group == null) throw new NotFoundError("No group with id {$id}");
        $group->setName($name);
        if ($this->entityManager->getRepository(User::class)->find($teacherId) != null)
            $group->setTeacherId($this->entityManager->getRepository(User::class)->find($teacherId));
        else throw new NotFoundError("No user with id {$teacherId}");

        $this->entityManager->flush();
    }

    public function delete(int $id): void
    {
        $group = $this->entityManager->getRepository(Group::class)->find($id);
        if ($group == null) throw new NotFoundError("No group with id {$id}");
        $this->entityManager->remove($group);
        $this->entityManager->flush();
    }

    public function getAll(?int $userId): array
    {
        return $this->entityManager->getRepository(Group::class)->findAll();
    }

    public function getById(int $id): GroupModel
    {
        $group = $this->entityManager->getRepository(Group::class)->findOneBy(
            ['id' => $id]
        );
        if ($group == null) throw new NotFoundError("No group with id {$id}");

        return new GroupModel(
            $id,
            $group->getName(),
            $group->getGroupMatch()->getUserId()->getValues(),
            $group->getTeacherId()->getId()
        );
    }

    public function addUsers(int $groupId, array $usersId): void
    {
        $usgr = $this->entityManager->getRepository(UserGroup::class)->findOneBy(
            ['group_id' => $groupId]
        );
        if ($usgr == null) throw new NotFoundError("No UserGroup with group_id {$groupId}");
        foreach ($usersId as &$usr)
            if ($this->entityManager->getRepository(User::class)->find($usr))
                $usgr->addUserId($this->entityManager->getRepository(User::class)->find($usr));
        
        $this->entityManager->flush();
    }

    public function deleteUsers(int $groupId, array $usersId): void
    {
        $usgr = $this->entityManager->getRepository(UserGroup::class)->findOneBy(
            ['group_id' => $groupId]
        );
        if ($usgr == null) throw new NotFoundError("No UserGroup with group_id {$groupId}");
        foreach ($usersId as &$usr)
            $usgr->removeUserId($usr);
        
        $this->entityManager->flush();
    }

    public function addLab(int $groupId, int $labId): void
    {
        $group = $this->entityManager->getRepository(Group::class)->findOneBy(
            ['id' => $groupId]
        );
        if ($group == null) throw new NotFoundError("No group with id {$groupId}");

        if ($this->entityManager->getRepository(Lab::class)->find($labId) != null)
            $group->addIssuedLab($this->entityManager->getRepository(Lab::class)->find($labId));

        $this->entityManager->flush();
    }

    public function deleteLab(int $groupId, int $labId): void
    {
        $group = $this->entityManager->getRepository(Group::class)->findOneBy(
            ['id' => $groupId]
        );
        if ($group == null) throw new NotFoundError("No group with id {$groupId}");

        $group->removeIssuedLab($this->entityManager->getRepository(Lab::class)->find($labId));

        $this->entityManager->flush();
    }
}