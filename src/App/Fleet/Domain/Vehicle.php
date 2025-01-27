<?php

declare(strict_types=1);

namespace App\Fleet\Domain;

use App\Fleet\Domain\Dto\VehicleInputData;
use App\Fleet\Domain\Enum\VehicleStatus;
use App\Fleet\Domain\Enum\VehicleType;
use App\Fleet\Domain\Policy\AddVehicle\VehicleCanBeAdded;
use App\Fleet\Domain\ValueObject\AssignedUnitId;
use App\Fleet\Domain\ValueObject\VehicleName;
use App\Fleet\Domain\ValueObject\VehiclePlateNumber;
use App\Fleet\Domain\ValueObject\VehicleProductionDate;
use App\Shared\BusinessRuleUtilities\Domain\Exception\BusinessRuleViolationException;
use App\Shared\DomainUtilities\Domain\AggregateRoot;
use App\Shared\DomainUtilities\Exception\InvalidDataException;

/**
 * Aggregate root for Fleet bounded context
 *
 * @author Mariusz Waloszczyk
 */
final class Vehicle extends AggregateRoot
{
    private VehiclePlateNumber $plateNumber;
    private VehicleType $type;
    private VehicleName $name;
    private VehicleStatus $status;
    private VehicleProductionDate $productionDate;
    private AssignedUnitId $assignedUnitId;

    /**
     * Create a new instance of vehicle aggregate
     *
     * @param VehicleInputData $inputData
     * @param VehicleCanBeAdded $vehicleCanBeAdded
     * @throws BusinessRuleViolationException
     * @throws InvalidDataException
     */
    public function __construct(
        VehicleInputData $inputData,
        VehicleCanBeAdded $vehicleCanBeAdded
    ) {
        $vehicleCanBeAdded->isSatisfiedBy($inputData)
            ->validate();

        $this->plateNumber = VehiclePlateNumber::fromString($inputData->plateNumber);
        $this->type = VehicleType::from($inputData->type);
        $this->name = VehicleName::fromMakeAndModel($inputData->make, $inputData->model);
        $this->status = VehicleStatus::from($inputData->status);
        $this->productionDate = VehicleProductionDate::fromYearAndMonth(
            $inputData->productionYear,
            $inputData->productionMonth
        );
        $this->assignedUnitId = AssignedUnitId::fromString($inputData->fireBrigadeUnitId);
        // TODO dispatch domain event
    }
}
