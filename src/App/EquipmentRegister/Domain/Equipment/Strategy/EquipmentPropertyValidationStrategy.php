<?php

namespace App\EquipmentRegister\Domain\Equipment\Strategy;

use App\EquipmentRegister\Domain\Equipment\ValueObject\EquipmentPropertyValue;

/**
 * Check if the provided property value is correct based on template property type
 *
 * @author Mariusz Waloszczyk
 */
interface EquipmentPropertyValidationStrategy
{
    /**
     * Check if the provided property value is correct based on template property type
     *
     * @param EquipmentPropertyValue $propertyValue
     * @return bool
     * @author Mariusz Waloszczyk
     */
    public function isValid(EquipmentPropertyValue $propertyValue): bool;
}
