<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Application\EquipmentManufacturer\Service;

use App\EquipmentRegister\Domain\EquipmentManufacturer\Dto\EquipmentManufacturerInputData;

/**
 * API service exposing equipment manufacturer operations to other bounded contexts and UI layer
 *
 * @author Mariusz Waloszczyk
 */
interface EquipmentManufacturerApiService
{
    /**
     * Create a new manufacturer
     *
     * @param EquipmentManufacturerInputData $inputData
     * @return void
     * @author Mariusz Waloszczyk
     */
    public function createManufacturer(EquipmentManufacturerInputData $inputData): void;
}
