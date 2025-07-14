<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Infrastructure\EquipmentTemplate\Repository\Persistence\Doctrine\Type\Identifier;

use App\EquipmentRegister\Domain\EquipmentTemplate\ValueObject\EquipmentTemplatePropertyDefinitionId;
use App\Shared\Infrastructure\Doctrine\Type\Identifier\AbstractIntegerIdentifierType;

/**
 * Custom type for equipment template definition id
 *
 * @author Mariusz Waloszczyk
 */
final class EquipmentTemplatePropertyDefinitionIdType extends AbstractIntegerIdentifierType
{
    /**
     * Unique name of the type
     */
    public const string NAME = 'equipment_template_property_definition_id';

    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    protected function fromInt(int $value): object
    {
        return EquipmentTemplatePropertyDefinitionId::fromInt($value);
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
