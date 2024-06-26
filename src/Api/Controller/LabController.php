<?php

namespace App\Api\Controller;

use App\Api\Auth\User;
use App\Api\Request\Lab\StoreRequest;
use App\Api\Response\IdStoreResponse;
use App\Api\Response\Lab\IndexResponse;
use App\Api\Response\Lab\ShowResponse;
use App\Api\Response\NoContentResponse;
use App\Domain\Error\AccessDeniedError;
use App\Domain\Model\FileModel;
use App\Domain\Service\LabService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

#[Route('/labs')]
class LabController extends AbstractController
{
    public function __construct(private readonly LabService $service)
    {
    }

    #[Route('', methods: ['POST'])]
    public function store(StoreRequest $request): IdStoreResponse
    {
        $this->denyAccessUnlessGranted('ROLE_TEACHER');

        $id = $this->service->create($request->name, $request->description, $request->groupId);

        return new IdStoreResponse($id);
    }

    #[Route('', methods: ['GET'])]
    public function index(
        #[MapQueryParameter(filter: FILTER_VALIDATE_INT, options: ['min_range' => 1])] ?int $group = null
    ): IndexResponse
    {
        $users = $this->service->getAll($group);

        return new IndexResponse($users);
    }

    #[Route('/{id}', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(int $id): ShowResponse
    {
        $user = $this->service->get($id);

        return new ShowResponse($user);
    }

    /**
     * @throws AccessDeniedError
     */
    #[Route('/{id}', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    public function delete(#[CurrentUser] User $user, int $id): NoContentResponse
    {
        $this->denyAccessUnlessGranted('ROLE_TEACHER');

        if ($user->getRoles()[0] != 'ROLE_ADMIN' && !$this->service->isTeacher($user->getId(), $id)) {
            throw new AccessDeniedError();
        }

        $this->service->delete($id);

        return new NoContentResponse();
    }

    /**
     * @throws AccessDeniedError
     */
    #[Route('/{id}/', requirements: ['id' => '\d+'], methods: ['PATCH'])]
    public function updateDesc(#[CurrentUser] User $user, int $id, StoreRequest $request): NoContentResponse
    {
        $this->denyAccessUnlessGranted('ROLE_TEACHER');

        if ($user->getRoles()[0] != 'ROLE_ADMIN' && !$this->service->isTeacher($user->getId(), $id)) {
            throw new AccessDeniedError();
        }

        $this->service->delete($id);

        $this->service->update($id, $request->name, $request->description, $request->groupId);

        return new NoContentResponse();
    }

    /**
     * @throws AccessDeniedError
     */
    #[Route('/{id}/files', requirements: ['id' => '\d+'], methods: ['POST'])]
    public function updateFiles(#[CurrentUser] User $user, int $id, Request $request): NoContentResponse
    {
        $this->denyAccessUnlessGranted('ROLE_TEACHER');

        if ($user->getRoles()[0] != 'ROLE_ADMIN' && !$this->service->isTeacher($user->getId(), $id)) {
            throw new AccessDeniedError();
        }

        $tmpDst = $this->getParameter('kernel.project_dir') . '/uploads';

        $uploadedFiles = $request->files->keys();
        $files = [];
        foreach ($uploadedFiles as $upFile) {
            $file = $request->files->get($upFile);
            $tmpPath = $file->move($tmpDst)->getPathname();
            $name = $file->getClientOriginalName();
            $files[] = new FileModel(0, $name, $tmpPath, labId: $id);
        }

        $this->service->updateFiles($id, $files);

        // todo clear files
        return new NoContentResponse();
    }
}