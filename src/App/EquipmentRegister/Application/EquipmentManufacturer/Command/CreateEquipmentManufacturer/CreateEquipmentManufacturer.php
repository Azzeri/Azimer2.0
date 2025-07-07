<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Application\EquipmentManufacturer\Command\CreateEquipmentManufacturer;

use App\EquipmentRegister\Domain\EquipmentManufacturer\Dto\EquipmentManufacturerInputData;

/**
 * Command creating a new equipment manufacturer
 *
 * @author Mariusz Waloszczyk
 */
final readonly class CreateEquipmentManufacturer
{
    /**
     * @param EquipmentManufacturerInputData $inputData
     */
    public function __construct(
        public EquipmentManufacturerInputData $inputData,
    ) {
    }
}
