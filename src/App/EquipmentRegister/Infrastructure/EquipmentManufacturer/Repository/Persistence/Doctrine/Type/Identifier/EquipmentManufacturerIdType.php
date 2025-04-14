<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Infrastructure\EquipmentManufacturer\Repository\Persistence\Doctrine\Type\Identifier;

use App\EquipmentRegister\Domain\EquipmentManufacturer\ValueObject\EquipmentManufacturerId;
use App\Shared\DomainUtilities\Exception\InvalidDataException;
use App\Shared\Infrastructure\Doctrine\Type\Identifier\AbstractUuidIdentifierType;

/**
 * Custom type for equipment manufacturer id
 *
 * @author Mariusz Waloszczyk
 */
final class EquipmentManufacturerIdType extends AbstractUuidIdentifierType
{
    /**
     * Unique name of the type
     */
    public const string NAME = 'equipment_manufacturer_id';

    /**
     * @inheritDoc
     * @throws InvalidDataException
     * @author Mariusz Waloszczyk
     */
    protected function fromString(string $value): object
    {
        return EquipmentManufacturerId::fromString($value);
    }

    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    protected function getClassName(): string
    {
        return EquipmentManufacturerId::class;
    }
}
