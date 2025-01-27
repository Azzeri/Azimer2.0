<?php

declare(strict_types=1);

namespace App\Fleet\Domain\Repository;

use App\Fleet\Domain\ValueObject\VehiclePlateNumber;
use App\Fleet\Domain\Vehicle;
use App\Shared\DomainUtilities\Exception\ResourceNotFoundException;

/**
 * A repository for a vehicle command model
 *
 * @author Mariusz Waloszczyk
 */
interface VehicleCommandModelRepository
{
    /**
     * Load the given vehicle aggregate from persistence
     *
     * @param VehiclePlateNumber $id
     * @return Vehicle
     * @throws ResourceNotFoundException
     * @author Mariusz Waloszczyk
     */
    public function loadById(VehiclePlateNumber $id): Vehicle;

    /**
     * Persists the given vehicle aggregate in its current state
     *
     * @param Vehicle $vehicle
     * @return void
     * @author Mariusz Waloszczyk
     */
    public function persist(Vehicle $vehicle): void;
}
