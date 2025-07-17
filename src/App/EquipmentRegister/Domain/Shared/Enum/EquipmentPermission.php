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

    /** Can add equipment to own unit */
    case EQUIPMENT_ADD_OWN_UNIT = 'equipment_add_own_unit';

    /** Can add equipment to any unit */
    case EQUIPMENT_ADD_ALL_UNITS = 'equipment_add_all_units';

    /** Can add equipment to subservient units */
    case EQUIPMENT_ADD_SUBSERVIENT_UNITS = 'equipment_add_subservient_units';
}
