<?php

declare(strict_types=1);

namespace App\Security\Application\Tenant\Command\AuthenticateTenant;

use App\Security\Domain\Tenant\Service\AuthenticateTenantService;
use App\Security\Domain\Tenant\ValueObject\PlainPassword;
use App\Security\Domain\Tenant\ValueObject\TenantId;
use App\Shared\CqrsUtilities\Domain\Repository\RuntimeMessageCollectorRepository;
use App\Shared\CqrsUtilities\Domain\ValueObject\RuntimeMessage;
use Ecotone\Modelling\Attribute\CommandHandler;

/**
 * Handler for {@see AuthenticateTenantCommand}
 *
 * @author Mariusz Waloszczyk
 */
final readonly class AuthenticateTenantCommandHandler
{
    public const string JWT_TOKEN_MESSAGE_KEY = 'GENERATED_JWT_TOKEN';

    /**
     * @param AuthenticateTenantService $authenticateTenantService
     * @param RuntimeMessageCollectorRepository $runtimeMessageCollectorRepository
     * @author Mariusz Waloszczyk
     */
    public function __construct(
        private AuthenticateTenantService $authenticateTenantService,
        private RuntimeMessageCollectorRepository $runtimeMessageCollectorRepository,
    ) {
    }

    /**
     * @param AuthenticateTenantCommand $command
     * @return void
     * @author Mariusz Waloszczyk
     */
    #[CommandHandler]
    public function handle(AuthenticateTenantCommand $command): void
    {
        $token = $this->authenticateTenantService->authenticate(
            TenantId::fromEmail($command->email),
            PlainPassword::fromString($command->password)
        );
        $this->runtimeMessageCollectorRepository->addMessage(
            RuntimeMessage::fromKeyAndValue(self::JWT_TOKEN_MESSAGE_KEY, $token->value())
        );
    }
}
