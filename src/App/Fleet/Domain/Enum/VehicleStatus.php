<?php

declare(strict_types=1);

namespace App\Fleet\Domain\Enum;

/**
 * Statuses representing a lifecycle of a vehicle
 *
 * @author Mariusz Waloszczyk
 */
enum VehicleStatus: string
{
    /** Vehicle being currently used */
    case IN_USE = 'in_use';

    /** Vehicle that cannot be currently used and awaits maintenance */
    case AWAITING_MAINTENANCE = 'awaiting_maintenance';

    /** Vehicle that is currently undergoing maintenance */
    case IN_MAINTENANCE = 'in_maintenance';

    /** Vehicle that was abandoned and will not be used anymore */
    case ABANDONED = 'abandoned';
}
