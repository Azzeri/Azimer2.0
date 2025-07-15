<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Infrastructure\EquipmentTemplate\Repository\Persistence\Doctrine\Type\Identifier;

use App\EquipmentRegister\Domain\EquipmentTemplate\ValueObject\EquipmentTemplatePropertyDefinitionId;
use App\Shared\DomainUtilities\Exception\InvalidDataException;
use App\Shared\Infrastructure\Doctrine\Type\Identifier\AbstractUuidIdentifierType;

/**
 * Custom type for equipment template definition ID
 *
 * @author Mariusz Waloszczyk
 */
final class EquipmentTemplatePropertyDefinitionIdType extends AbstractUuidIdentifierType
{
    /**
     * Unique name of the type
     */
    public const string NAME = 'equipment_template_property_definition_id';

    /**
     * @inheritDoc
     * @throws InvalidDataException
     * @author Mariusz Waloszczyk
     */
    protected function fromString(string $value): object
    {
        return EquipmentTemplatePropertyDefinitionId::fromString($value);
    }

    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    protected function getClassName(): string
    {
        return EquipmentTemplatePropertyDefinitionId::class;
    }
}
