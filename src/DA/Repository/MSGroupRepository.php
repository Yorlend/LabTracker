<?php

namespace App\DA\Repository;

use App\DA\Entity\Comment;
use App\DA\Entity\Group;
use App\DA\Entity\Lab;
use App\DA\Entity\User;
use App\Domain\Error\NotFoundError;
use App\Domain\Model\GroupModel;
use App\Domain\Repository\IGroupRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class MSGroupRepository extends ServiceEntityRepository implements IGroupRepository
{
    public function __construct(
        private EntityManagerInterface $entityManager, ManagerRegistry $registry
    )
    {
        parent::__construct($registry, Group::class);
    }

    public function create(string $name, array $usersIds, int $teacherId): GroupModel
    {
        $group = new Group();

        $users = $this->entityManager->getRepository(User::class)->findBy([
            'id' => $usersIds
        ]);
        if (count($users) != count($usersIds)) throw new NotFoundError("Some of students are not exist");
        $teacher = $this->entityManager->getRepository(User::class)->find($teacherId);
        if ($teacher == null) throw new NotFoundError("No user with id {$teacherId}");

        $group->name = $name;
        $group->teacher = $teacher;
        foreach ($users as $user) {
            $group->users[] = $user;
            $user->groups[] =$group;
        }

        $this->entityManager->persist($group);
        $this->entityManager->flush();

        return new GroupModel(
            $group->id,
            $name,
            $usersIds,
            $teacherId
        );
    }

    public function update(int $id, string $name, int $teacherId): void
    {
        $group = $this->entityManager->getRepository(Group::class)->find($id);
        if ($group == null) throw new NotFoundError("No group with id {$id}");
        $teacher = $this->entityManager->getRepository(User::class)->find($teacherId);
        if ($teacher == null) throw new NotFoundError("No user with id {$teacherId}");

        $group->name = $name;
        $group->teacher = $teacher;

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
        $data = $this->entityManager->getRepository(Group::class)->findAll();

        $res = [];
        foreach ($data as $group) {
            $userIds = array_map(function ($entry) {
                return $entry->id;
            }, $group->users->toArray());

            $res[] = new GroupModel(
                $group->id,
                $group->name,
                $userIds,
                $group->teacher->id
            );
        }

        return $res;
    }

    public function getById(int $id): GroupModel
    {
        $group = $this->entityManager->getRepository(Group::class)->find($id);
        if ($group == null) throw new NotFoundError("No group with id {$id}");

        $userIds = array_map(function ($entry) {
            return $entry->id;
        }, $group->users->toArray());

        return new GroupModel(
            $group->id,
            $group->name,
            $userIds,
            $group->teacher->id
        );
    }

    public function addUsers(int $groupId, array $usersId): void
    {
        $group = $this->entityManager->getRepository(Group::class)->find($groupId);
        if ($group == null) throw new NotFoundError("No group with id {$groupId}");
        foreach ($usersId as $id){
            $user = $this->entityManager->getRepository(User::class)->find($id);
            if ($user == null) throw new NotFoundError("No user with id {$id}");
            $group->users->add($user);
        }

        $this->entityManager->flush();
    }

    public function deleteUsers(int $groupId, array $usersId): void
    {
        $group = $this->entityManager->getRepository(Group::class)->find($groupId);
        if ($group == null) throw new NotFoundError("No group with id {$groupId}");
        foreach ($usersId as $id){
            $user = $this->entityManager->getRepository(User::class)->find($id);
            if ($user == null) throw new NotFoundError("No user with id {$id}");
            $group->users->removeElement($user);
        }

        $this->entityManager->flush();
    }

    public function addLab(int $groupId, int $labId): void
    {
        $group = $this->entityManager->getRepository(Group::class)->find($groupId);
        if ($group == null) throw new NotFoundError("No group with id {$groupId}");
        $lab = $this->entityManager->getRepository(Lab::class)->find($labId);
        if ($lab == null) throw new NotFoundError("No lab with id {$labId}");

        $lab->group = $group;

        $this->entityManager->flush();
    }

    //todo delete
    public function deleteLab(int $groupId, int $labId): void
    {
        $lab = $this->entityManager->getRepository(Lab::class)->find($labId);
        if ($lab == null) throw new NotFoundError("No lab with id {$labId}");

        $this->entityManager->remove($lab);
        $this->entityManager->flush();
    }
}