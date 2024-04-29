<?php

namespace App\Api\Controller;

use App\Api\Request\Lab\StoreRequest;
use App\Api\Response\IdStoreResponse;
use App\Api\Response\Lab\IndexResponse;
use App\Api\Response\Lab\ShowResponse;
use App\Api\Response\NoContentResponse;
use App\Domain\Model\FileModel;
use App\Domain\Service\LabService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/labs')]
class LabController extends AbstractController
{
    public function __construct(private readonly LabService $service)
    {
    }

    #[Route('', methods: ['POST'])]
    public function store(StoreRequest $request): IdStoreResponse
    {
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

    #[Route('/{id}', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    public function delete(int $id): NoContentResponse
    {
        $this->service->delete($id);

        return new NoContentResponse();
    }

    #[Route('/{id}/', requirements: ['id' => '\d+'], methods: ['PATCH'])]
    public function updateDesc(int $id, StoreRequest $request): NoContentResponse
    {
        $this->service->update($id, $request->name, $request->description, $request->groupId);

        return new NoContentResponse();
    }

    #[Route('/{id}/files', requirements: ['id' => '\d+'], methods: ['POST'])]
    public function updateFiles(int $id, Request $request): NoContentResponse
    {
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