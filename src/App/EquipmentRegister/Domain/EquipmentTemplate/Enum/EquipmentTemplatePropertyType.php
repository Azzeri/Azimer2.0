<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Domain\EquipmentTemplate\Enum;

/**
 *
 *
 * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
 */
enum EquipmentTemplatePropertyType: string
{
    case YES_NO = 'yes_no';

    case DATE = 'date';

    case DATE_TIME = 'date_time';

    case TEXT = 'text';

    case INTEGER = 'integer';

    case DECIMAL = 'decimal';
}
