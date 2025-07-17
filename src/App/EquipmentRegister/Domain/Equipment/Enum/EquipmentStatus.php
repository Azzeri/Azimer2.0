<?php

namespace App\EquipmentRegister\Domain\Equipment\Enum;

/**
 * Possible statuses of equipment
 *
 * @author Mariusz Waloszczyk
 */
enum EquipmentStatus: string
{
    case ACTIVE = 'ACTIVE';
    case INACTIVE = 'INACTIVE';
}
