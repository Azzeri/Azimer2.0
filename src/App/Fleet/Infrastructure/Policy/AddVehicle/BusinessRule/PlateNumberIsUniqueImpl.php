<?php

namespace App\Fleet\Infrastructure\Policy\AddVehicle\BusinessRule;

use App\Fleet\Domain\Dto\VehicleInputData;
use App\Fleet\Domain\Policy\AddVehicle\BusinessRule\PlateNumberIsUnique;
use App\Fleet\Domain\ValueObject\FleetManager;
use App\Fleet\Domain\ValueObject\VehiclePlateNumber;
use App\Fleet\Infrastructure\Repository\Persistence\Doctrine\VehicleDoctrineRepository;
use App\Shared\BusinessRuleUtilities\Domain\ValueObject\BusinessRuleNotification;
use App\Shared\Domain\Repository\StandardRepository;
use App\Shared\DomainUtilities\Exception\InvalidDataException;
use App\Shared\DomainUtilities\Exception\ResourceNotFoundException;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

/**
 * Adapter of {@see PlateNumberIsUnique}
 *
 * @author Mariusz Waloszczyk
 */
final readonly class PlateNumberIsUniqueImpl implements PlateNumberIsUnique
{
    /**
     * @param StandardRepository $vehicleRepository
     */
    public function __construct(
        #[Autowire(service: VehicleDoctrineRepository::class)]
        private StandardRepository $vehicleRepository,
    ) {
    }

    /**
     * @inheritDoc
     * @throws InvalidDataException
     * @author Mariusz Waloszczyk
     */
    public function check(
        // TODO - maybe it would make more sense to create input data for every action without everything nullable?
        ?VehicleInputData $inputData = null,
        ?FleetManager $fleetManager = null,
    ): ?BusinessRuleNotification {
        if ($inputData === null || $inputData->plateNumber === null) {
            return BusinessRuleNotification::fromString("Missing data to validate plate number uniqueness");
        }

        try {
            $this->vehicleRepository->findById(VehiclePlateNumber::fromString($inputData->plateNumber));
        } catch (ResourceNotFoundException) {
            return null;
        }

        return BusinessRuleNotification::fromString("Vehicle's plate number: $inputData->plateNumber already exists");
    }
}
