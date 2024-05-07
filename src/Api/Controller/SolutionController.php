<?php

namespace App\Api\Controller;

use App\Api\Auth\User;
use App\Api\Request\Solution\CommentStoreRequest;
use App\Api\Request\Solution\StoreRequest;
use App\Api\Request\Solution\UpdateRequest;
use App\Api\Response\IdStoreResponse;
use App\Api\Response\NoContentResponse;
use App\Api\Response\Solution\IndexCommentResponse;
use App\Api\Response\Solution\IndexResponse;
use App\Api\Response\Solution\ShowResponse;
use App\Domain\Error\AccessDeniedError;
use App\Domain\Model\FileModel;
use App\Domain\Model\SolutionState;
use App\Domain\Service\CommentService;
use App\Domain\Service\SolutionService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

#[Route('/solutions')]
class SolutionController extends AbstractController
{
    public function __construct(private readonly SolutionService $service, private readonly CommentService $commentService)
    {
    }

    #[Route('', methods: ['POST'])]
    public function store(#[CurrentUser] User $user, StoreRequest $request): IdStoreResponse
    {
        $this->denyAccessUnlessGranted('ROLE_STUDENT');

        $id = $this->service->create($request->description, SolutionState::Checking, $request->labId, $user->getId());

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

    /**
     * @throws AccessDeniedError
     */
    #[Route('/{id}', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    public function delete(#[CurrentUser] User $user, int $id): NoContentResponse
    {
        $this->denyAccessUnlessGranted('ROLE_STUDENT');

        if ($user->getRoles()[0] != 'ROLE_ADMIN' && !$this->service->isOwner($user->getId(), $id)) {
            throw new AccessDeniedError();
        }

        $this->service->delete($id);

        return new NoContentResponse();
    }

    /**
     * @throws AccessDeniedError
     */
    #[Route('/{id}', requirements: ['id' => '\d+'], methods: ['PATCH'])]
    public function updateDesc(#[CurrentUser] User $user, int $id, UpdateRequest $request): NoContentResponse
    {
        $this->denyAccessUnlessGranted('ROLE_STUDENT');

        if ($user->getRoles()[0] != 'ROLE_ADMIN' && !$this->service->isOwner($user->getId(), $id)) {
            throw new AccessDeniedError();
        }

        $this->service->update($id, $request->description, SolutionState::from($request->state));

        return new NoContentResponse();
    }

    /**
     * @throws AccessDeniedError
     */
    #[Route('/{id}/files', requirements: ['id' => '\d+'], methods: ['POST'])]
    public function updateFiles(#[CurrentUser] User $user, int $id, Request $request): NoContentResponse
    {
        $this->denyAccessUnlessGranted('ROLE_STUDENT');

        if ($user->getRoles()[0] != 'ROLE_ADMIN' && !$this->service->isOwner($user->getId(), $id)) {
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

    #[Route('/{id}/comments', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function getComments(int $id): IndexCommentResponse
    {
        $comments = $this->commentService->getBySolutionId($id);

        return new IndexCommentResponse($comments);
    }

    #[Route('/{id}/comments', requirements: ['id' => '\d+'], methods: ['POST'])]
    public function addComment(#[CurrentUser] User $user, int $id, CommentStoreRequest $request): IdStoreResponse
    {
        $commentId = $this->commentService->create($id, $request->text, $user->getId());

        return new IdStoreResponse($commentId);
    }

    /**
     * @throws AccessDeniedError
     */
    #[Route('/{id}/comments/{commentId}', requirements: ['id' => '\d+', 'commentId' => '\d+'], methods: ['PUT'])]
    public function updateComment(#[CurrentUser] User $user, int $id, int $commentId, CommentStoreRequest $request): NoContentResponse
    {
        if ($user->getRoles()[0] != 'ROLE_ADMIN' && !$this->commentService->isOwner($user->getId(), $commentId)) {
            throw new AccessDeniedError();
        }

        $this->commentService->update($commentId, $request->text);

        return new NoContentResponse();
    }

    /**
     * @throws AccessDeniedError
     */
    #[Route('/{id}/comments/{commentId}', requirements: ['id' => '\d+', 'commentId' => '\d+'], methods: ['PUT'])]
    public function deleteComment(#[CurrentUser] User $user, int $id, int $commentId): NoContentResponse
    {
        if ($user->getRoles()[0] != 'ROLE_ADMIN' && !$this->commentService->isOwner($user->getId(), $commentId)) {
            throw new AccessDeniedError();
        }

        $this->commentService->delete($commentId);

        return new NoContentResponse();
    }
}