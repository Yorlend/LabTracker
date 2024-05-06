<?php

namespace App\DA\Repository;

use App\DA\Entity\User;
use App\DA\Entity\Group;
use App\Domain\Error\NotFoundError;
use App\Domain\Model\Role;
use App\Domain\Model\UserModel;
use App\Domain\Repository\IUserRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class MSUserRepository extends ServiceEntityRepository implements IUserRepository
{
    public function __construct(private EntityManagerInterface $entityManager, ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function create(string $userName, string $login, string $password, Role $role): UserModel
    {
        $user = new User();
        $user->user_name = $userName;
        $user->login = $login;
        $user->password = $password;
        $user->role = $role->value;

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $res =  new UserModel(
            $user->id,
            $userName,
            $login,
            $password,
            $role
        );

        return $res;
    }

    public function update(int $id, UserModel $user): void
    {
        $updatedUser = $this->entityManager->getRepository(User::class)->find($id);
        if ($updatedUser == null) throw new NotFoundError("No user with id {$id}");
        $updatedUser->user_name = $user->getUserName();
        $updatedUser->password = $user->getPassword();
        $updatedUser->role = $user->getRole()->value;

        $this->entityManager->flush();
    }

    public function delete(int $id): void
    {
        $user = $this->entityManager->getRepository(User::class)->find($id);
        if ($user == null) throw new NotFoundError("No user with id {$id}");
        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }

    public function getAll(int|null $groupId, Role|null $role): array
    {

        $res = [];
        if ($groupId == null && $role == null) {
            $data = $this->entityManager->getRepository(User::class)->findAll();
            foreach ($data as $user) {
                $res[] = new UserModel(
                    $user->id,
                    $user->user_name,
                    $user->login,
                    $user->password,
                    Role::from($user->role),
                );
            }
        }
        elseif ($groupId != null && $role == null) {
            $data = $this->entityManager->getRepository(Group::class)->find($groupId)->users;
            foreach ($data as $user) {
                $res[] = new UserModel(
                    $user->id,
                    $user->user_name,
                    $user->login,
                    $user->password,
                    Role::from($user->role),
                );
            }
        }
        elseif ($groupId == null && $role != null) {
            $data = $this->entityManager->getRepository(User::class)->findAll();
            foreach ($data as $user) {
                if (Role::from($user->role) == $role)
                {
                    $res[] = new UserModel(
                        $user->id,
                        $user->user_name,
                        $user->login,
                        $user->password,
                        Role::from($user->role),
                    );
                }
            }
        }
        else {
            $data = $this->entityManager->getRepository(Group::class)->find($groupId)->users;
            foreach ($data as $user) {
                if (Role::from($user->role) == $role)
                {
                    $res[] = new UserModel(
                        $user->id,
                        $user->user_name,
                        $user->login,
                        $user->password,
                        Role::from($user->role),
                    );
                }
            }
        }


        return $res;
    }

    public function getById(int $id): UserModel
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(
            ['id' => $id]
        );
        if ($user == null) throw new NotFoundError("No user with id {$id}");
        return new UserModel(
            $user->id,
            $user->user_name,
            $user->login,
            $user->password,
            Role::from($user->role)
        );
    }

    public function getByLogin(string $login): UserModel
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(
            ['login' => $login]
        );
        if ($user == null) throw new NotFoundError("No user with login {$login}");
        return new UserModel(
            $user->id,
            $user->user_name,
            $user->login,
            $user->password,
            Role::from($user->role)
        );
    }
}