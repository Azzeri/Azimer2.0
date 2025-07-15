<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Application\EquipmentTemplate\Command\CreateEquipmentTemplate;

use App\EquipmentRegister\Domain\EquipmentTemplate\Dto\EquipmentTemplateInputData;

/**
 * Command creating a new equipment template
 *
 * @author Mariusz Waloszczyk
 */
final readonly class CreateEquipmentTemplate
{
    /**
     * @param EquipmentTemplateInputData $inputData
     */
    public function __construct(
        public EquipmentTemplateInputData $inputData,
    ) {
    }
}
