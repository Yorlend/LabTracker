<?php

namespace App\Api\Controller;

use App\Domain\Service\FileService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Mime\MimeTypes;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/files')]
class FileController extends AbstractController
{

    public function __construct(private readonly FileService $service)
    {
    }

    #[Route('/{id}', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function getFile(int $id): BinaryFileResponse
    {
        $file = $this->service->getFile($id);

        $response = new BinaryFileResponse($file->getPath());

        $mimeTypes = new MimeTypes();
        if ($mimeTypes->isGuesserSupported()) {
            $response->headers->set('Content-Type', $mimeTypes->guessMimeType($file->getPath()));
        } else {
            $response->headers->set('Content-Type', 'text/plain');
        }

        $response->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            $file->getName()
        );

        return $response;
    }
}