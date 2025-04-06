<?php

declare(strict_types=1);

namespace App\FireBrigadeUnit\Application\Command\AddFireBrigadeUnit;

/**
 * Command creating a new fire brigade unit
 *
 * @author Mariusz Waloszczyk
 */
final readonly class AddFireBrigadeUnitCommand
{
    /**
     * @param string|null $superiorUnitId
     * @author Mariusz Waloszczyk
     */
    public function __construct(
        public ?string $superiorUnitId = null
    ) {
    }
}
