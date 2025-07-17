<?php

namespace App\EquipmentRegister\Domain\Equipment\Invariant\Definition;

use App\EquipmentRegister\Domain\Equipment\Invariant\EquipmentInvariant;

/**
 * Make sure that equipment has valid properties:
 *  - property for every template property is set to a value or null, if allowed
 *  - every property is validated depending on its type, e.g. dates are valid dates, boolean is YES/NO etc.
 *
 * @author Mariusz Waloszczyk
 */
interface EquipmentPropertiesAreValid extends EquipmentInvariant
{
}
