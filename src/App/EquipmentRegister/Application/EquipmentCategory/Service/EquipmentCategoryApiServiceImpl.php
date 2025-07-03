<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Application\EquipmentCategory\Service;

use App\EquipmentRegister\Application\EquipmentCategory\Command\CreateEquipmentCategory\CreateEquipmentCategory;
use App\EquipmentRegister\Domain\EquipmentCategory\Dto\EquipmentCategoryInputData;
use Ecotone\Modelling\CommandBus;

/**
 * Implementation of {@see EquipmentCategoryApiService}
 *
 * @author Mariusz Waloszczyk<mwaloszczyk@ottoworkforce.eu>
 */
final readonly class EquipmentCategoryApiServiceImpl implements EquipmentCategoryApiService
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
     * @author Mariusz Waloszczyk<mwaloszczyk@ottoworkforce.eu>
     */
    public function createCategory(EquipmentCategoryInputData $inputData): void
    {
        $this->commandBus->send(new CreateEquipmentCategory($inputData));
    }
}
