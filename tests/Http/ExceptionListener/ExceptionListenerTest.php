<?php

declare(strict_types=1);

use App\Shared\BusinessRuleUtilities\Domain\Exception\BusinessRuleViolationException;
use App\Shared\DomainUtilities\Exception\ResourceNotFoundException;
use App\Shared\DomainUtilities\Exception\UnauthorizedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use UI\Http\ExceptionListener\ExceptionListener;

it(
    'handles ResourceNotFoundException with 404 response',
    function () {
        $kernel = Mockery::mock(HttpKernelInterface::class);
        $listener = new ExceptionListener('dev');
        $exception = new ResourceNotFoundException('Resource not found');
        $event = new ExceptionEvent($kernel, new Request(), HttpKernelInterface::MAIN_REQUEST, $exception);

        $listener($event);

        expect($event->getResponse()?->getStatusCode())->toBe(Response::HTTP_NOT_FOUND)
            ->and($event->getResponse()?->getContent())->toContain('Resource not found');
    }
);

it('handles UnauthorizedException with 403 response in production', function () {
    $kernel = Mockery::mock(HttpKernelInterface::class);
    $listener = new ExceptionListener('prod');
    $exception = new UnauthorizedException('Access denied');
    $event = new ExceptionEvent($kernel, new Request(), HttpKernelInterface::MAIN_REQUEST, $exception);

    $listener($event);

    expect($event->getResponse()?->getStatusCode())->toBe(Response::HTTP_FORBIDDEN)
        ->and($event->getResponse()?->getContent())->toContain('User not authorized');
});

it('handles UnauthorizedException with 403 response in non-production', function () {
    $kernel = Mockery::mock(HttpKernelInterface::class);
    $listener = new ExceptionListener('dev');
    $exception = new UnauthorizedException('Access denied');
    $event = new ExceptionEvent($kernel, new Request(), HttpKernelInterface::MAIN_REQUEST, $exception);

    $listener($event);

    expect($event->getResponse()?->getStatusCode())->toBe(Response::HTTP_FORBIDDEN)
        ->and($event->getResponse()?->getContent())->toContain('Access denied')
        ->and($event->getResponse()?->getContent())->toContain('trace');
});

it('handles BusinessRuleViolationException with 422 response', function () {
    $kernel = Mockery::mock(HttpKernelInterface::class);
    $listener = new ExceptionListener('dev');
    $exception = new BusinessRuleViolationException('Business rule violated');
    $event = new ExceptionEvent($kernel, new Request(), HttpKernelInterface::MAIN_REQUEST, $exception);

    $listener($event);

    expect($event->getResponse()?->getStatusCode())->toBe(Response::HTTP_UNPROCESSABLE_ENTITY)
        ->and($event->getResponse()?->getContent())->toContain('Business rule violated');
});

it('handles generic exceptions with 500 response in production', function () {
    $kernel = Mockery::mock(HttpKernelInterface::class);
    $listener = new ExceptionListener('prod');
    $exception = new RuntimeException('Unexpected error');
    $event = new ExceptionEvent($kernel, new Request(), HttpKernelInterface::MAIN_REQUEST, $exception);

    $listener($event);

    expect($event->getResponse()?->getStatusCode())->toBe(Response::HTTP_INTERNAL_SERVER_ERROR)
        ->and($event->getResponse()?->getContent())->toContain('Internal server error');
});

it('handles generic exceptions with full trace in non-production', function () {
    $kernel = Mockery::mock(HttpKernelInterface::class);
    $listener = new ExceptionListener('dev');
    $exception = new RuntimeException('Unexpected error');
    $event = new ExceptionEvent($kernel, new Request(), HttpKernelInterface::MAIN_REQUEST, $exception);

    $listener($event);

    expect($event->getResponse()?->getStatusCode())->toBe(Response::HTTP_INTERNAL_SERVER_ERROR)
        ->and($event->getResponse()?->getContent())->toContain('Unexpected error')
        ->and($event->getResponse()?->getContent())->toContain('trace');
});
