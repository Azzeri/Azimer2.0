<?php

declare(strict_types=1);

namespace App\Fleet\Domain\Enum;

/**
 * Permissions defining access to fleet functionalities
 *
 * @author Mariusz Waloszczyk
 */
enum FleetPermission: string
{
    /** Add vehicles to all units in the system */
    case ADD_ALL = 'add_all';

    /** Add vehicles only to the unit assigned to manager */
    case ADD_OWN = 'add_own';

    /** Add vehicles to units that are subservient to unit assigned to manager */
    case ADD_SUBSERVIENT = 'add_subservient';
}
