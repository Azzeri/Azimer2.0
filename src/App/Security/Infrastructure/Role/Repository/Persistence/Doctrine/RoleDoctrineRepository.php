<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\Role\Repository\Persistence\Doctrine;

use App\Security\Domain\Role\Repository\RoleRepository;
use App\Security\Domain\Role\Role;
use App\Shared\Infrastructure\Doctrine\StandardRepositoryDoctrineImpl;
use Ecotone\Modelling\Attribute\Repository;

/**
 * Doctrine implementation of {@see RoleRepository}
 *
 * @author Mariusz Waloszczyk
 */
#[Repository]
final readonly class RoleDoctrineRepository extends StandardRepositoryDoctrineImpl implements RoleRepository
{
    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    public function getClassName(): string
    {
        return Role::class;
    }

    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    public function getIdentifierPropertyName(): string
    {
        return 'name';
    }
}
