<?php

declare(strict_types=1);

namespace App\Fleet\Application\Query\Definition;

/**
 * Find a single vehicle by its identifier
 *
 * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
 */
final readonly class FindVehicleQuery
{
    /**
     * @param string $plateNumber
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    public function __construct(
        public string $plateNumber
    ) {
    }
}
