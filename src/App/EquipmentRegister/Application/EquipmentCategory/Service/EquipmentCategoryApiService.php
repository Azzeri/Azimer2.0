<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Application\EquipmentCategory\Service;

use App\EquipmentRegister\Domain\EquipmentCategory\Dto\EquipmentCategoryInputData;

/**
 * API service exposing equipment category operations to other bounded contexts and UI layer
 *
 * @author Mariusz Waloszczyk<mwaloszczyk@ottoworkforce.eu>
 */
interface EquipmentCategoryApiService
{
    /**
     * Create a new category
     *
     * @param EquipmentCategoryInputData $inputData
     * @return void
     * @author Mariusz Waloszczyk<mwaloszczyk@ottoworkforce.eu>
     */
    public function createCategory(EquipmentCategoryInputData $inputData): void;
}
