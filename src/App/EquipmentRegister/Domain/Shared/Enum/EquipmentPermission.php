<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Domain\Shared\Enum;

/**
 * A permission specifying action that the equipment manager can perform
 *
 * @author Mariusz Waloszczyk
 */
enum EquipmentPermission: string
{
    /** Can add a new equipment category */
    case CATEGORY_ADD = 'equipment_category_add';

    /** Can add a new equipment manufacturer */
    case MANUFACTURER_ADD = 'equipment_manufacturer_add';

    /** Can add a new equipment template */
    case TEMPLATE_ADD = 'equipment_template_add';
}
