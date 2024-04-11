<?php

namespace App\Domain\Service;

use App\Domain\Model\GroupModel;
use App\Domain\Repository\IGroupRepository;

class GroupService
{
    /**
     * @param IGroupRepository $repository репозиторий групп
     */
    public function __construct(private readonly IGroupRepository $repository)
    {
    }

    /**
     * @param int[] $users id студентов
     * @param int $teacherId id преподавателя
     * @return int id созданного пользователя
     */
    public function create(
        array $users,
        int   $teacherId,
    ): int
    {
        return $this->repository->create($users, $teacherId)->getId();
    }

    /**
     * @param int|null $userId id пользователя, для фильтрации
     * @return GroupModel[] все группы
     */
    public function getAll(?int $userId = null): array
    {
        return $this->repository->getAll($userId);
    }

    /**
     * @param int $id id группы
     * @return GroupModel искомая группа
     */
    public function get(int $id): GroupModel
    {
        return $this->repository->getById($id);
    }

    /**
     * @param int $id id группы
     * @return void
     */
    public function delete(int $id): void
    {
        $this->repository->delete($id);
    }

    /**
     * @param int $id id пользователя
     * @param GroupModel $group обновленная группа
     */
    public function update(int $id, GroupModel $group): void
    {
        $this->repository->update($id, $group);
    }

    /**
     * @param int $groupId id группы, в которую добавляются пользователи
     * @param array $usersId id пользователей, которых нужно добавить
     * @return void
     */
    public function addUsers(int $groupId, array $usersId): void
    {
        $this->repository->addUsers($groupId, $usersId);
    }

    /**
     * @param int $groupId id группы, из которой удаляются пользователи
     * @param array $usersId id пользователей, которых нужно удалить
     * @return void
     */
    public function deleteUsers(int $groupId, array $usersId): void
    {
        $this->repository->deleteUsers($groupId, $usersId);
    }

    /**
     * @param int $groupId id группы, в которую добавляется лаба
     * @param int $labId id добавляемой лабы
     * @return void
     */
    public function addLab(int $groupId, int $labId): void
    {
        $this->repository->addLab($groupId, $labId);
    }

    /**
     * @param int $groupId id группы, из которой удаляется лаба
     * @param int $labId id удаляемой лабы
     * @return void
     */
    public function deleteLab(int $groupId, int $labId): void
    {
        $this->repository->deleteLab($groupId, $labId);
    }
}