<?php

declare(strict_types=1);

namespace App\Fleet\Application\Query\Definition;

/**
 * Find a single vehicle by its identifier
 *
 * @author Mariusz Waloszczyk
 */
final readonly class FindVehicleQuery
{
    /**
     * @param string $plateNumber
     * @author Mariusz Waloszczyk
     */
    public function __construct(
        public string $plateNumber
    ) {
    }
}
