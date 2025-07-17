<?php

namespace App\EquipmentRegister\Domain\Equipment\Strategy\Definition;

use App\EquipmentRegister\Domain\Equipment\Strategy\EquipmentPropertyValidationStrategy;
use App\EquipmentRegister\Domain\Equipment\ValueObject\EquipmentPropertyValue;

/**
 * Implementation of {@see EquipmentPropertyValidationStrategy} checking if value is a valid float
 *
 * @author Mariusz Waloszczyk
 */
final readonly class EquipmentPropertyValidationFloatStrategy implements EquipmentPropertyValidationStrategy
{
    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    public function isValid(EquipmentPropertyValue $propertyValue): bool
    {
        return filter_var($propertyValue->getValue(), FILTER_VALIDATE_FLOAT) !== false;
    }
}
