<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Infrastructure\EquipmentCategory\Repository\Persistence\Doctrine\Type\Identifier;

use App\EquipmentRegister\Domain\EquipmentCategory\ValueObject\EquipmentCategoryId;
use App\Shared\DomainUtilities\Exception\InvalidDataException;
use App\Shared\Infrastructure\Doctrine\Type\Identifier\AbstractUuidIdentifierType;

/**
 * Custom type for equipment category id
 *
 * @author Mariusz Waloszczyk
 */
final class EquipmentCategoryIdType extends AbstractUuidIdentifierType
{
    /**
     * Unique name of the type
     */
    public const string NAME = 'equipment_category_id';

    /**
     * @inheritDoc
     * @throws InvalidDataException
     * @author Mariusz Waloszczyk
     */
    protected function fromString(string $value): object
    {
        return EquipmentCategoryId::fromString($value);
    }

    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    protected function getClassName(): string
    {
        return EquipmentCategoryId::class;
    }
}
