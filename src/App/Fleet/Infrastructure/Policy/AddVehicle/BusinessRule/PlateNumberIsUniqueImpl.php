<?php

namespace App\Fleet\Infrastructure\Policy\AddVehicle\BusinessRule;

use App\Fleet\Domain\Dto\VehicleInputData;
use App\Fleet\Domain\Policy\AddVehicle\BusinessRule\PlateNumberIsUnique;
use App\Fleet\Domain\ValueObject\FleetManager;
use App\Fleet\Domain\Vehicle;
use App\Fleet\Infrastructure\Doctrine\Repository\VehicleDoctrineRepository;
use App\Shared\BusinessRuleUtilities\Domain\ValueObject\BusinessRuleNotification;
use Ecotone\Modelling\StandardRepository;
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
     * @author Mariusz Waloszczyk
     */
    public function check(
        ?VehicleInputData $inputData = null,
        ?FleetManager $fleetManager = null,
    ): ?BusinessRuleNotification {
        if ($inputData === null || empty($inputData->plateNumber)) {
            return BusinessRuleNotification::fromString("Missing data to validate plate number uniqueness");
        }

        $vehicleWithPlateNumber = $this->vehicleRepository->findBy(
            Vehicle::class,
            ['plateNumber' => $inputData->plateNumber]
        );

        return $vehicleWithPlateNumber === null
            ? null
            : BusinessRuleNotification::fromString("Vehicle's plate number: $inputData->plateNumber already exists");
    }
}
