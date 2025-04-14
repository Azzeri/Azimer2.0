<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Infrastructure\Equipment\Repository\Persistence\Doctrine\Type\Identifier;

use App\EquipmentRegister\Domain\Equipment\ValueObject\EquipmentId;
use App\Shared\DomainUtilities\Exception\InvalidDataException;
use App\Shared\Infrastructure\Doctrine\Type\Identifier\AbstractUuidIdentifierType;

/**
 * Custom type for equipment id
 *
 * @author Mariusz Waloszczyk
 */
final class EquipmentIdType extends AbstractUuidIdentifierType
{
    /**
     * Unique name of the type
     */
    public const string NAME = 'equipment_id';

    /**
     * @inheritDoc
     * @throws InvalidDataException
     * @author Mariusz Waloszczyk
     */
    protected function fromString(string $value): object
    {
        return EquipmentId::fromString($value);
    }

    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    protected function getClassName(): string
    {
        return EquipmentId::class;
    }
}
