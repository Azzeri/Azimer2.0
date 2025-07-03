<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Infrastructure\Shared\Factory;

use App\EquipmentRegister\Domain\Shared\Enum\EquipmentPermission;
use App\EquipmentRegister\Domain\Shared\Factory\EquipmentManagerFactory;
use App\EquipmentRegister\Domain\Shared\ValueObject\EquipmentManager;
use App\Fleet\Domain\ValueObject\FleetManager;
use App\Shared\DomainUtilities\Domain\Actor;
use App\Shared\Infrastructure\Factory\ActorFactoryAuthenticatedEmployeeImpl;

/**
 * Implementation of {@see EquipmentManagerFactory} creating instance of {@see FleetManager}
 *
 * @author Mariusz Waloszczyk<mwaloszczyk@ottoworkforce.eu>
 */
final readonly class EquipmentManagerFactoryImpl extends ActorFactoryAuthenticatedEmployeeImpl implements
    EquipmentManagerFactory
{
    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk<mwaloszczyk@ottoworkforce.eu>
     */
    protected function getPermissionEnum(): string
    {
        return EquipmentPermission::class;
    }

    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk<mwaloszczyk@ottoworkforce.eu>
     */
    protected function createActorInstance(string $identifier, array $permissions, string $organizationalUnitId): Actor
    {
        return new EquipmentManager($identifier, $permissions, $organizationalUnitId);
    }
}
