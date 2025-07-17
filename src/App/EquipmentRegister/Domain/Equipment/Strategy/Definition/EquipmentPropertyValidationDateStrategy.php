<?php

namespace App\EquipmentRegister\Domain\Equipment\Strategy\Definition;

use App\EquipmentRegister\Domain\Equipment\Strategy\EquipmentPropertyValidationStrategy;
use App\EquipmentRegister\Domain\Equipment\ValueObject\EquipmentPropertyValue;

/**
 * Implementation of {@see EquipmentPropertyValidationStrategy} checking if value is a valid date
 *
 * @author Mariusz Waloszczyk
 */
final readonly class EquipmentPropertyValidationDateStrategy implements EquipmentPropertyValidationStrategy
{
    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    public function isValid(EquipmentPropertyValue $propertyValue): bool
    {
        $date = \DateTime::createFromFormat('Y-m-d', $propertyValue->getValue());
        return $date !== false && $date->format('Y-m-d') === $propertyValue->getValue();
    }
}
