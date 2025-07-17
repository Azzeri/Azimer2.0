<?php

namespace App\EquipmentRegister\Domain\Equipment\Strategy\Definition;

use App\EquipmentRegister\Domain\Equipment\Strategy\EquipmentPropertyValidationStrategy;
use App\EquipmentRegister\Domain\Equipment\ValueObject\EquipmentPropertyValue;

/**
 * Implementation of {@see EquipmentPropertyValidationStrategy} checking if value is a valid integer
 *
 * @author Mariusz Waloszczyk
 */
final readonly class EquipmentPropertyValidationIntegerStrategy implements EquipmentPropertyValidationStrategy
{
    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    public function isValid(EquipmentPropertyValue $propertyValue): bool
    {
        return filter_var($propertyValue->getValue(), FILTER_VALIDATE_INT) !== false;
    }
}
