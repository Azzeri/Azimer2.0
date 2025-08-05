<?php

declare(strict_types=1);

namespace App\EquipmentUsage\Infrastructure\Repository\Persistence\Doctrine\Type\Identifier;

use App\EquipmentUsage\Domain\ValueObject\EquipmentUsageId;
use App\Shared\DomainUtilities\Exception\InvalidDataException;
use App\Shared\Infrastructure\Doctrine\Type\Identifier\AbstractUuidIdentifierType;

/**
 * Custom type for equipment usage id
 *
 * @author Mariusz Waloszczyk
 */
final class EquipmentUsageIdType extends AbstractUuidIdentifierType
{
    /**
     * Unique name of the type
     */
    public const string NAME = 'equipment_usage_id';

    /**
     * @inheritDoc
     * @throws InvalidDataException
     * @author Mariusz Waloszczyk
     */
    protected function fromString(string $value): object
    {
        return EquipmentUsageId::fromString($value);
    }

    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    protected function getClassName(): string
    {
        return EquipmentUsageId::class;
    }
}
