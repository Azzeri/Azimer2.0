<?php

namespace App\EquipmentRegister\Domain\Equipment\Factory\EquipmentPropertyValidationStrategy;

use App\EquipmentRegister\Domain\Equipment\ValueObject\EquipmentPropertyValue;
use App\EquipmentRegister\Domain\EquipmentTemplate\Enum\EquipmentTemplatePropertyDefinitionType;

/**
 * Choose the valid factory depending on template property type
 *
 * @author Mariusz Waloszczyk
 */
interface EquipmentPropertyValidationStrategyFactory
{
    /**
     * Choose the valid factory depending on template property type and check if is valid
     *
     * @param EquipmentPropertyValue $propertyValue
     * @param EquipmentTemplatePropertyDefinitionType $definitionType
     * @return bool
     * @author Mariusz Waloszczyk
     */
    public function isValid(
        EquipmentPropertyValue $propertyValue,
        EquipmentTemplatePropertyDefinitionType $definitionType
    ): bool;
}
