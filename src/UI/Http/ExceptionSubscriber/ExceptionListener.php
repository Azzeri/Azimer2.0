<?php

declare(strict_types=1);

namespace UI\Http\ExceptionSubscriber;

use App\Shared\BusinessRuleUtilities\Domain\Exception\BusinessRuleViolationException;
use App\Shared\DomainUtilities\Exception\ResourceNotFoundException;
use App\Shared\DomainUtilities\Exception\UnauthorizedException;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Throwable;

/**
 * Defines how API should react to different kinds of exceptions thrown
 *
 * @author Mariusz Waloszczyk
 */
final readonly class ExceptionListener
{
    /**
     * @param string $environmentMode
     * @author Mariusz Waloszczyk
     */
    public function __construct(
        #[Autowire('%kernel.environment%')]
        private string $environmentMode
    ) {
    }

    /**
     * @param ExceptionEvent $event
     * @return void
     * @author Mariusz Waloszczyk
     */
    public function __invoke(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        $response = new JsonResponse();

        if ($exception instanceof ResourceNotFoundException) {
            $response->setStatusCode(Response::HTTP_NOT_FOUND);
            $response->setData($exception->getMessage());
        } elseif ($exception instanceof UnauthorizedException) {
            $response->setStatusCode(Response::HTTP_FORBIDDEN);
            $response->setData($this->getExceptionResponse($exception, "User not authorized"));
        } elseif ($exception instanceof BusinessRuleViolationException) {
            $response->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
            $response->setData($exception->getMessage());
        } else {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            $response->setData($this->getExceptionResponse($exception, "Internal server error"));
        }

        $event->setResponse($response);
    }

    /**
     * Prepare a response message
     *
     * @param Throwable $exception
     * @param string $productionMessage
     * @return mixed[]
     * @author Mariusz Waloszczyk
     */
    private function getExceptionResponse(Throwable $exception, string $productionMessage): array
    {
        $isProductionMode = $this->environmentMode === 'prod';
        return $isProductionMode
            ? ['error' => $productionMessage]
            : [
                'error' => [
                    'message' => $exception->getMessage(),
                    'trace' => $exception->getTrace(),
                ]
            ];
    }
}
