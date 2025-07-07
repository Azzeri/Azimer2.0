<?php

namespace App\EquipmentRegister\Domain\EquipmentManufacturer\Invariant\Definition;

use App\EquipmentRegister\Domain\EquipmentManufacturer\Invariant\EquipmentManufacturerInvariant;

/**
 * Make sure that manufacturer name is unique
 *
 * @author Mariusz Waloszczyk
 */
interface ManufacturerNameIsUnique extends EquipmentManufacturerInvariant
{
}
