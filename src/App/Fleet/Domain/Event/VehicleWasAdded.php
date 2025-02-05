<?php

declare(strict_types=1);

namespace App\Fleet\Domain\Event;

/**
 * Event published when a new vehicle was added
 *
 * @author Mariusz Waloszczyk
 */
final readonly class VehicleWasAdded
{
    /**
     * @param string $VehiclePlateNumber
     *
     * @author Mariusz Waloszczyk
     */
    public function __construct(
        public string $VehiclePlateNumber,
    ) {
    }
}
