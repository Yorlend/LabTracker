<?php

namespace App\Api\Error;

use App\Domain\Error\AccessDeniedError;
use App\Domain\Error\BadRequestError;
use App\Domain\Error\NotFoundError;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * Слушатель исключений, для правильного http ответа
 */
#[AsEventListener(event: "kernel.exception")]
class ExceptionListener
{
    /**
     * Преобразует исключение в http ответ
     *
     * @param ExceptionEvent $event событие
     * @return void
     */
    public function __invoke(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        $response = new JsonResponse();
        $response->setData([
            "msg" => $exception->getMessage()
        ]);

        if ($exception instanceof NotFoundError) {
            $response->setStatusCode(Response::HTTP_NOT_FOUND);
        } elseif ($exception instanceof AccessDeniedError) {
            $response->setStatusCode(Response::HTTP_FORBIDDEN);
        } elseif ($exception instanceof AccessDeniedHttpException) {
            $response->setStatusCode(Response::HTTP_FORBIDDEN);
        } elseif ($exception instanceof BadRequestError) {
            $response->setStatusCode(Response::HTTP_BAD_REQUEST);
        } else {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $event->setResponse($response);
    }
}