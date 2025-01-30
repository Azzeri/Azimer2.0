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
use App\Fleet\Infrastructure\Doctrine\Type\Identifier\VehiclePlateNumberType;
use App\Shared\BusinessRuleUtilities\Domain\Exception\BusinessRuleViolationException;
use App\Shared\DomainUtilities\Domain\AggregateRoot;
use App\Shared\DomainUtilities\Exception\InvalidDataException;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Aggregate root for Fleet bounded context
 *
 * @author Mariusz Waloszczyk
 * TODO - I wonder if I should assign AssignedUnit or AssignedUnitId?
 */
#[ORM\Entity]
final class Vehicle extends AggregateRoot
{
    /**
     * @param VehiclePlateNumber $plateNumber
     * @param VehicleType $type
     * @param VehicleName $name
     * @param VehicleStatus $status
     * @param VehicleProductionDate $productionDate
     * @param AssignedUnitId $assignedUnitId
     */
    private function __construct(
        #[ORM\Id]
        #[ORM\Column(type: VehiclePlateNumberType::NAME, length: VehiclePlateNumber::MAX_LENGTH, unique: true)]
        private VehiclePlateNumber $plateNumber,
        #[ORM\Column(type: Types::STRING, enumType: VehicleType::class)]
        private VehicleType $type,
        #[ORM\Embedded(class: VehicleName::class)]
        private VehicleName $name,
        #[ORM\Column(type: Types::STRING, enumType: VehicleStatus::class)]
        private VehicleStatus $status,
        #[ORM\Embedded(class: VehicleProductionDate::class)]
        private VehicleProductionDate $productionDate,
        #[ORM\Embedded(class: AssignedUnitId::class)]
        private AssignedUnitId $assignedUnitId
    ) {
    }

    /**
     * Create a new instance of vehicle aggregate
     *
     * @param VehicleInputData $inputData
     * @param VehicleCanBeAdded $vehicleCanBeAdded
     * @return Vehicle
     * @throws BusinessRuleViolationException
     * @throws InvalidDataException
     */
    public static function fromInputData(
        VehicleInputData $inputData,
        VehicleCanBeAdded $vehicleCanBeAdded
    ): self {
        $vehicleCanBeAdded->isSatisfiedBy($inputData)
            ->validate();

        return new self(
            VehiclePlateNumber::fromString($inputData->plateNumber),
            VehicleType::from($inputData->type),
            VehicleName::fromMakeAndModel($inputData->make, $inputData->model),
            VehicleStatus::from($inputData->status),
            VehicleProductionDate::fromYearAndMonth(
                $inputData->productionYear,
                $inputData->productionMonth
            ),
            AssignedUnitId::fromString($inputData->fireBrigadeUnitId)
        );
        // TODO dispatch domain event
    }
}
