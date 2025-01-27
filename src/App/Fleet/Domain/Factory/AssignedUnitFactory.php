<?php

declare(strict_types=1);

namespace App\Fleet\Domain\Factory;

use App\Fleet\Domain\ValueObject\AssignedUnit;
use App\Fleet\Domain\ValueObject\AssignedUnitId;
use App\Shared\DomainUtilities\Exception\ResourceNotFoundException;

/**
 * This factory should be used to create instances of FireBrigadeUnit
 *
 * @author Mariusz Waloszczyk
 */
interface AssignedUnitFactory
{
    /**
     * Create instance of FireBrigadeUnit from the provided ID
     *
     * @param AssignedUnitId $id
     * @return AssignedUnit
     * @throws ResourceNotFoundException
     * @author Mariusz Waloszczyk
     */
    public function createFromIdentifier(AssignedUnitId $id): AssignedUnit;
}
