<?php

declare(strict_types=1);

namespace App\Fleet\Domain;

use App\Fleet\Application\Command\AddVehicleCommand;
use App\Fleet\Domain\Enum\VehicleStatus;
use App\Fleet\Domain\Enum\VehicleType;
use App\Fleet\Domain\Event\VehicleWasAdded;
use App\Fleet\Domain\Policy\AddVehicle\VehicleCanBeAdded;
use App\Fleet\Domain\ValueObject\AssignedUnitId;
use App\Fleet\Domain\ValueObject\VehicleName;
use App\Fleet\Domain\ValueObject\VehiclePlateNumber;
use App\Fleet\Domain\ValueObject\VehicleProductionDate;
use App\Fleet\Infrastructure\Persistence\Doctrine\Type\Identifier\VehiclePlateNumberType;
use App\Shared\BusinessRuleUtilities\Domain\Exception\BusinessRuleViolationException;
use App\Shared\DomainUtilities\Domain\AggregateRoot;
use App\Shared\DomainUtilities\Exception\InvalidDataException;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Ecotone\Messaging\Attribute\Parameter\Reference;
use Ecotone\Modelling\Attribute as CQRS;
use Ecotone\Modelling\WithEvents;

/**
 * Aggregate root for Fleet bounded context
 * @psalm-suppress UnusedProperty
 * @author Mariusz Waloszczyk
 * TODO - I wonder if I should assign AssignedUnit or AssignedUnitId?
 */
#[ORM\Entity]
#[CQRS\Aggregate]
final class Vehicle extends AggregateRoot
{
    use WithEvents;

    /**
     * @param VehiclePlateNumber $plateNumber
     * @param VehicleType $type
     * @param VehicleName $name
     * @param VehicleStatus $status
     * @param VehicleProductionDate $productionDate
     * @param AssignedUnitId $assignedUnitId
     */
    private function __construct(
        /** @phpstan-ignore-next-line */
        #[ORM\Id]
        #[CQRS\Identifier]
        #[ORM\Column(type: VehiclePlateNumberType::NAME, length: VehiclePlateNumber::MAX_LENGTH, unique: true)]
        private VehiclePlateNumber $plateNumber,
        /** @phpstan-ignore-next-line */
        #[ORM\Column(type: Types::STRING, enumType: VehicleType::class)]
        private VehicleType $type,
        /** @phpstan-ignore-next-line */
        #[ORM\Embedded(class: VehicleName::class)]
        private VehicleName $name,
        /** @phpstan-ignore-next-line */
        #[ORM\Column(type: Types::STRING, enumType: VehicleStatus::class)]
        private VehicleStatus $status,
        /** @phpstan-ignore-next-line */
        #[ORM\Embedded(class: VehicleProductionDate::class)]
        private VehicleProductionDate $productionDate,
        /** @phpstan-ignore-next-line */
        #[ORM\Embedded(class: AssignedUnitId::class)]
        private AssignedUnitId $assignedUnitId
    ) {
        $this->recordThat(new VehicleWasAdded((string)$plateNumber));
    }

    /**
     * Create a new instance of vehicle aggregate
     *
     * @param AddVehicleCommand $addVehicleCommand
     * @param VehicleCanBeAdded $vehicleCanBeAdded
     * @return Vehicle
     * @throws BusinessRuleViolationException
     * @throws InvalidDataException
     * @psalm-suppress PossiblyNullArgument // TODO - disabled when input data will be fixed
     */
    #[CQRS\CommandHandler()]
    public static function fromInputData(
        AddVehicleCommand $addVehicleCommand,
        #[Reference] VehicleCanBeAdded $vehicleCanBeAdded
    ): self {
        $inputData = $addVehicleCommand->vehicleInputData;

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
            AssignedUnitId::fromString($inputData->assignedUnitId)
        );
    }
}
