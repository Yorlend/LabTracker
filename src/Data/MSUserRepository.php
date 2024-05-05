<?php 

namespace App\Data;

use App\Domain\Error\NotFoundError;
use App\Domain\Repository\IUserRepository;
use App\Domain\Model\Role;
use App\Domain\Model\UserModel;
use App\Entity\User;
use App\Entity\UserGroup;
use Doctrine\ORM\EntityManagerInterface;

class MSUserRepository implements IUserRepository
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function create(string $userName, string $login, string $password, Role $role): UserModel
    {
        $user = new User();

        $user->setUserName($userName);
        $user->setLogin($login);
        $user->setPassword($password);
        $user->setRole($role->value);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return new UserModel(
            $user->getId(),
            $userName,
            $login,
            $password,
            $role
        );
    }

    public function update(int $id, UserModel $user): void
    {
        $user1 = $this->entityManager->getRepository(User::class)->find($id);
        if ($user1 == null) throw new NotFoundError("No user with id {$id}");
        $user1->setLogin($user->getLogin());
        $user1->setPassword($user->getPassword());
        $user1->setRole($user->getRole()->value);
        $user1->setUserName($user->getUserName());

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
        // return $this->entityManager->getRepository(User::class)->findBy(
        //     ['group_id' == $groupId],
        //     ['role' == $role]
        // );
        if ($groupId == null && $role == null)
            return $this->entityManager->getRepository(User::class)->findAll();
        else if ($role == null)
            return $this->entityManager->getRepository(UserGroup::class)->findOneBy(
                ['group_id' => $groupId]
            )->getUserId()->toArray();
        else if ($role != null && $groupId == null)
            return $this->entityManager->getRepository(User::class)->findBy(
                ['role' => $role->value]
            );
        $arr = $this->entityManager->getRepository(UserGroup::class)->findOneBy(
            ['group_id' == $groupId])->getUserId()->toArray();

        $ret = array();
        foreach ($arr as &$el)
            if ($el->role == $role)
                array_push($ret, $el);
        return $ret;
    }

    public function getById(int $id): UserModel
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(
            ['id' => $id]
        );
        if ($user == null) throw new NotFoundError("No user with id {$id}");
        return new UserModel(
            $user->getId(),
            $user->getUserName(),
            $user->getLogin(),
            $user->getPassword(),
            Role::from($user->getRole())
        );
    }

    public function getByLogin(string $login): UserModel
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(
            ['login' => $login]
        );
        if ($user == null) throw new NotFoundError("No user with login {$login}");
        return new UserModel(
            $user->getId(),
            $user->getUserName(),
            $user->getLogin(),
            $user->getPassword(),
            Role::from($user->getRole())
        );
    }
}