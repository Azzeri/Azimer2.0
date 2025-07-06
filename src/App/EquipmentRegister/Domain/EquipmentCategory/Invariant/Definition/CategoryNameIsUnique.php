<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Domain\EquipmentCategory\Invariant\Definition;

use App\EquipmentRegister\Domain\EquipmentCategory\Invariant\EquipmentCategoryInvariant;

/**
 * Invariant ensuring that category's name is unique
 *
 * @author Mariusz Waloszczyk
 */
interface CategoryNameIsUnique extends EquipmentCategoryInvariant
{
}
