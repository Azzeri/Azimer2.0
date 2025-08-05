<?php

namespace App\EquipmentUsage\Domain\Invariant\Definition;

use App\EquipmentUsage\Domain\Invariant\EquipmentUsageInvariant;

/**
 * Make sure there are no overlapping usages for the equipment
 *
 * @author Mariusz Waloszczyk
 */
interface UsagesNotOverlapping extends EquipmentUsageInvariant
{
}
