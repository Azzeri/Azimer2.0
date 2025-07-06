<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Domain\EquipmentCategory\Invariant\Definition;

use App\EquipmentRegister\Domain\EquipmentCategory\Invariant\EquipmentCategoryInvariant;

/**
 * Invariant ensuring that category's parent is valid
 *
 * @author Mariusz Waloszczyk
 */
interface ParentCategoryIsValid extends EquipmentCategoryInvariant
{
}
