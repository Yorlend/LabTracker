<?php

namespace App\Api\Controller;

use App\Api\Request\Group\StoreRequest;
use App\Api\Request\Group\UpdateRequest;
use App\Api\Request\Group\UsersIdRequest;
use App\Api\Response\Group\IndexResponse;
use App\Api\Response\Group\ShowResponse;
use App\Api\Response\IdStoreResponse;
use App\Api\Response\NoContentResponse;
use App\Domain\Service\GroupService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/groups')]
class GroupController extends AbstractController
{
    public function __construct(private readonly GroupService $service)
    {
    }

    #[Route('', methods: ['POST'])]
    public function store(StoreRequest $request): IdStoreResponse
    {
        $id = $this->service->create($request->name, $request->usersId, $request->teacherId);

        return new IdStoreResponse($id);
    }

    #[Route('', methods: ['GET'])]
    public function index(
        #[MapQueryParameter(filter: FILTER_VALIDATE_INT, options: ['min_range' => 1])] ?int $user = null
    ): IndexResponse
    {
        $users = $this->service->getAll($user);

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
        $this->service->update($id, $request->name, $request->teacherId);

        return new NoContentResponse();
    }

    #[Route('/{id}', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    public function delete(int $id): NoContentResponse
    {
        $this->service->delete($id);

        return new NoContentResponse();
    }

    #[Route('/{id}/users', requirements: ['id' => '\d+'], methods: ['POST'])]
    public function addUser(int $id, UsersIdRequest $request): IdStoreResponse
    {
        $this->service->addUsers($id, $request->usersId);

        return new IdStoreResponse($id);
    }

    #[Route('/{id}/users', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    public function deleteUser(int $id, UsersIdRequest $request): NoContentResponse
    {
        $this->service->deleteUsers($id, $request->usersId);

        return new NoContentResponse();
    }

    #[Route('/{id}/lab/{labId}', requirements: ['id' => '\d+', 'labId' => '\d+'], methods: ['POST'])]
    public function addLab(int $id, int $labId): IdStoreResponse
    {
        $this->service->addLab($id, $labId);

        return new IdStoreResponse($id);
    }

    #[Route('/{id}/lab/{labId}', requirements: ['id' => '\d+', 'labId' => '\d+'], methods: ['DELETE'])]
    public function deleteLab(int $id, int $labId): NoContentResponse
    {
        $this->service->deleteLab($id, $labId);

        return new NoContentResponse();
    }
}