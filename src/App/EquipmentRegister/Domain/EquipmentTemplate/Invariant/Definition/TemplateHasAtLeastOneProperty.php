<?php

namespace App\EquipmentRegister\Domain\EquipmentTemplate\Invariant\Definition;

use App\EquipmentRegister\Domain\EquipmentTemplate\Invariant\EquipmentTemplateInvariant;

/**
 * Make sure that template has at least one property assigned
 *
 * @author Mariusz Waloszczyk
 */
interface TemplateHasAtLeastOneProperty extends EquipmentTemplateInvariant
{
}
