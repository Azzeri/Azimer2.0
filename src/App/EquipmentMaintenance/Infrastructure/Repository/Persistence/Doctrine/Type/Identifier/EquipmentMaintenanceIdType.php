<?php

declare(strict_types=1);

namespace App\EquipmentMaintenance\Infrastructure\Repository\Persistence\Doctrine\Type\Identifier;

use App\EquipmentMaintenance\Domain\ValueObject\EquipmentMaintenanceId;
use App\Shared\DomainUtilities\Exception\InvalidDataException;
use App\Shared\Infrastructure\Doctrine\Type\Identifier\AbstractUuidIdentifierType;

/**
 * Custom type for equipment maintenance id
 *
 * @author Mariusz Waloszczyk
 */
final class EquipmentMaintenanceIdType extends AbstractUuidIdentifierType
{
    /**
     * Unique name of the type
     */
    public const string NAME = 'equipment_maintenance_id';

    /**
     * @inheritDoc
     * @throws InvalidDataException
     * @author Mariusz Waloszczyk
     */
    protected function fromString(string $value): object
    {
        return EquipmentMaintenanceId::fromString($value);
    }

    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    protected function getClassName(): string
    {
        return EquipmentMaintenanceId::class;
    }
}
