<?php

declare(strict_types=1);

namespace App\Security\Application\Command\AddTenant;

use App\Security\Domain\Tenant\Enum\TenantStatus;
use App\Security\Domain\Tenant\Tenant;
use App\Security\Domain\Tenant\ValueObject\Password;
use App\Security\Domain\Tenant\ValueObject\TenantId;
use App\Security\Infrastructure\Tenant\Repository\Persistence\Doctrine\TenantDoctrineRepository;
use App\Shared\Domain\Repository\StandardRepository;
use Ecotone\Modelling\Attribute\CommandHandler;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

/**
 * Handler for {@see AddTenantCommand}
 *
 * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
 */
final readonly class AddTenantCommandHandler
{
    /**
     * @param StandardRepository $tenantRepository
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    public function __construct(
        #[Autowire(service: TenantDoctrineRepository::class)]
        private StandardRepository $tenantRepository,
    ) {
    }

    /**
     * @param AddTenantCommand $command
     * @return void
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    #[CommandHandler]
    public function handle(AddTenantCommand $command): void
    {
        // TODO - implement policy checking UserManager permissions, email uniqueness, password rules
        $tenant = new Tenant(
            TenantId::fromEmail($command->email),
            Password::fromNonHashedString($command->password),
            TenantStatus::from($command->status)
        );
        $this->tenantRepository->persist($tenant);
    }
}
