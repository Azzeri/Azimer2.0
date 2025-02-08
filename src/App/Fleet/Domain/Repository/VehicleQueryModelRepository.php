<?php

declare(strict_types=1);

namespace App\Fleet\Domain\Repository;

use App\Fleet\Domain\Dto\VehicleQueryModel;
use App\Fleet\Domain\ValueObject\VehiclePlateNumber;
use Ramsey\Collection\Collection;

/**
 * This repository is used to query vehicles
 *
 * @author Mariusz Waloszczyk
 */
interface VehicleQueryModelRepository
{
    /**
     * Find a single vehicle by its id or return null
     *
     * @param VehiclePlateNumber $plateNumber
     * @return VehicleQueryModel|null
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    public function findByPlateNumber(VehiclePlateNumber $plateNumber): ?VehicleQueryModel;

    /**
     * Find vehicles by the criteria provided
     *
     * @return Collection<VehicleQueryModel>
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    public function search(): Collection;
}
