<?php

namespace App\Api\Controller;

use App\Api\Request\User\StoreRequest;
use App\Api\Request\User\UpdateRequest;
use App\Api\Response\IdStoreResponse;
use App\Api\Response\NoContentResponse;
use App\Api\Response\User\IndexResponse;
use App\Api\Response\User\ShowResponse;
use App\Domain\Error\BadRequestError;
use App\Domain\Error\NotFoundError;
use App\Domain\Model\Role;
use App\Domain\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;
use const FILTER_VALIDATE_INT;

#[Route('/users')]
class UserController extends AbstractController
{
    public function __construct(private readonly UserService $service)
    {
    }

    #[Route('', methods: ['POST'])]
    public function store(StoreRequest $request): IdStoreResponse
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $caught = false;
        try {
            $this->service->getByLogin($request->login);
        } catch (NotFoundError $e){
            $caught = true;
        }
        if (!$caught) throw new  BadRequestError("Login must be uniq");

        $id = $this->service->create($request->userName, $request->login, $request->password, Role::from($request->role));

        return new IdStoreResponse($id);

    }

    #[Route('', methods: ['GET'])]
    public function index(
        #[MapQueryParameter(filter: FILTER_VALIDATE_INT, options: ['min_range' => 1])] ?int $group = null,
        #[MapQueryParameter(filter: FILTER_VALIDATE_INT, options: ['min_range' => 1])] ?int $role = null): IndexResponse
    {
        $users = $this->service->getAll($group, $role);

        return new IndexResponse($users);
    }

    #[Route('/{id}', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(int $id): ShowResponse
    {
        $user = $this->service->get($id);

        return new ShowResponse($user);
    }

    #[Route('/{id}', requirements: ['id' => '\d+'], methods: ['PUT'])]
    public function update(int $id, UpdateRequest $request): NoContentResponse
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $this->service->update($id, $request->toEntity());

        return new NoContentResponse();
    }

    #[Route('/{id}', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    public function delete(int $id): NoContentResponse
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $this->service->delete($id);

        return new NoContentResponse();
    }
}