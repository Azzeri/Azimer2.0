<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Application\EquipmentManufacturer\Service;

use App\EquipmentRegister\Application\EquipmentManufacturer\Command\CreateEquipmentManufacturer\CreateEquipmentManufacturer;
use App\EquipmentRegister\Domain\EquipmentManufacturer\Dto\EquipmentManufacturerInputData;
use Ecotone\Modelling\CommandBus;

/**
 * Implementation of {@see EquipmentManufacturerApiService}
 *
 * @author Mariusz Waloszczyk
 */
final readonly class EquipmentManufacturerApiServiceImpl implements EquipmentManufacturerApiService
{
    /**
     * @param CommandBus $commandBus
     */
    public function __construct(
        private CommandBus $commandBus,
    ) {
    }

    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    public function createManufacturer(EquipmentManufacturerInputData $inputData): void
    {
        $this->commandBus->send(new CreateEquipmentManufacturer($inputData));
    }
}
