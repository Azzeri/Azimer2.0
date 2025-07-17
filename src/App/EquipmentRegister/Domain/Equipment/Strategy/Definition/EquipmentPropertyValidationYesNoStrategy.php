<?php

namespace App\EquipmentRegister\Domain\Equipment\Strategy\Definition;

use App\EquipmentRegister\Domain\Equipment\Strategy\EquipmentPropertyValidationStrategy;
use App\EquipmentRegister\Domain\Equipment\ValueObject\EquipmentPropertyValue;

/**
 * Implementation of {@see EquipmentPropertyValidationStrategy} checking YES/NO values
 *
 * @author Mariusz Waloszczyk
 */
final readonly class EquipmentPropertyValidationYesNoStrategy implements EquipmentPropertyValidationStrategy
{
    private const string YES = 'YES';
    private const string NO = 'NO';

    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    public function isValid(EquipmentPropertyValue $propertyValue): bool
    {
        return $propertyValue->getValue() === self::YES || $propertyValue->getValue() === self::NO;
    }
}
