<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Application\EquipmentCategory\Command\CreateEquipmentCategory;

use App\EquipmentRegister\Domain\EquipmentCategory\Dto\EquipmentCategoryInputData;

/**
 * Command creating a new equipment category
 *
 * @author Mariusz Waloszczyk
 */
final readonly class CreateEquipmentCategory
{
    /**
     * @param EquipmentCategoryInputData $inputData
     */
    public function __construct(
        public EquipmentCategoryInputData $inputData,
    ) {
    }
}
