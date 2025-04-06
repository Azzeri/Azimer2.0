<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\Tenant\Repository\Persistence\Doctrine;

use App\Security\Domain\Tenant\Repository\TenantRepository;
use App\Security\Domain\Tenant\Tenant;
use App\Shared\Infrastructure\Doctrine\StandardRepositoryDoctrineImpl;
use Ecotone\Modelling\Attribute\Repository;

/**
 * Doctrine implementation of {@see TenantRepository}
 *
 * @author Mariusz Waloszczyk
 */
#[Repository]
final readonly class TenantDoctrineRepository extends StandardRepositoryDoctrineImpl implements TenantRepository
{
    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    public function getClassName(): string
    {
        return Tenant::class;
    }

    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    public function getIdentifierPropertyName(): string
    {
        return 'id';
    }
}
