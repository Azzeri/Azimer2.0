<?php

namespace App\Fleet\Infrastructure\Policy\AddVehicle\BusinessRule;

use App\Fleet\Application\Command\AddVehicleCommand;
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
 * Implementation of {@see PlateNumberIsUnique}
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
        // TODO - create custom VehicleRepository, like TenantRepository
        private StandardRepository $vehicleRepository,
    ) {
    }

    /**
     * @inheritDoc
     * @throws InvalidDataException
     * @author Mariusz Waloszczyk
     */
    public function check(AddVehicleCommand $command, FleetManager $fleetManager): ?BusinessRuleNotification
    {
        try {
            $this->vehicleRepository->findById(VehiclePlateNumber::fromString($command->plateNumber));
        } catch (ResourceNotFoundException) {
            return null;
        }

        return BusinessRuleNotification::fromString("Vehicle's plate number: $command->plateNumber already exists");
    }
}
