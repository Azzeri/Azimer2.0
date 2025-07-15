<?php

namespace App\EquipmentRegister\Domain\EquipmentTemplate\Invariant\Definition;

use App\EquipmentRegister\Domain\EquipmentTemplate\Invariant\EquipmentTemplateInvariant;

/**
 * Make sure that template name is unique
 *
 * @author Mariusz Waloszczyk
 */
interface TemplateNameIsUnique extends EquipmentTemplateInvariant
{
}
