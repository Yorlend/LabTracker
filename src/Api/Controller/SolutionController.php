<?php

namespace App\Api\Controller;

use App\Api\Request\Solution\CommentStoreRequest;
use App\Api\Request\Solution\StoreRequest;
use App\Api\Request\Solution\UpdateRequest;
use App\Api\Response\IdStoreResponse;
use App\Api\Response\NoContentResponse;
use App\Api\Response\Solution\IndexCommentResponse;
use App\Api\Response\Solution\IndexResponse;
use App\Api\Response\Solution\ShowResponse;
use App\Domain\Model\FileModel;
use App\Domain\Model\SolutionState;
use App\Domain\Service\CommentService;
use App\Domain\Service\SolutionService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/solutions')]
class SolutionController extends AbstractController
{
    public function __construct(private readonly SolutionService $service, private readonly CommentService $commentService)
    {
    }

    #[Route('', methods: ['POST'])]
    public function store(StoreRequest $request): IdStoreResponse
    {
        // todo add curent user id
        $id = $this->service->create($request->description, SolutionState::Checking, $request->labId, 0);

        return new IdStoreResponse($id);
    }

    #[Route('', methods: ['GET'])]
    public function index(
        #[MapQueryParameter(filter: FILTER_VALIDATE_INT, options: ['min_range' => 1])] ?int $lab = null,
        #[MapQueryParameter(filter: FILTER_VALIDATE_INT, options: ['min_range' => 1])] ?int $state = null
    ): IndexResponse
    {
        $sols = $this->service->getAll($lab, $state);

        return new IndexResponse($sols);
    }

    #[Route('/{id}', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(int $id): ShowResponse
    {
        $solution = $this->service->get($id);

        return new ShowResponse($solution);
    }

    #[Route('/{id}', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    public function delete(int $id): NoContentResponse
    {
        $this->service->delete($id);

        return new NoContentResponse();
    }

    #[Route('/{id}', requirements: ['id' => '\d+'], methods: ['PATCH'])]
    public function updateDesc(int $id, UpdateRequest $request): NoContentResponse
    {
        $this->service->update($id, $request->description, SolutionState::from($request->state));

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

    #[Route('/{id}/comments', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function getComments(int $id): IndexCommentResponse
    {
        $comments = $this->commentService->getBySolutionId($id);

        return new IndexCommentResponse($comments);
    }

    #[Route('/{id}/comments', requirements: ['id' => '\d+'], methods: ['POST'])]
    public function addComment(int $id, CommentStoreRequest $request): IdStoreResponse
    {
        // todo add curent user id
        $commentId = $this->commentService->create($id, $request->text);

        return new IdStoreResponse($commentId);
    }

    #[Route('/{id}/comments/{commentId}', requirements: ['id' => '\d+', 'commentId' => '\d+'], methods: ['PUT'])]
    public function updateComment(int $id, int $commentId, CommentStoreRequest $request): NoContentResponse
    {
        $this->commentService->update($commentId, $request->text);

        return new NoContentResponse();
    }

    #[Route('/{id}/comments/{commentId}', requirements: ['id' => '\d+', 'commentId' => '\d+'], methods: ['PUT'])]
    public function deleteComment(int $id, int $commentId): NoContentResponse
    {
        $this->commentService->delete($commentId);

        return new NoContentResponse();
    }
}