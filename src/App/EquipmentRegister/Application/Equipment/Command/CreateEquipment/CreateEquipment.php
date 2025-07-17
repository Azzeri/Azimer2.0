<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Application\Equipment\Command\CreateEquipment;

use App\EquipmentRegister\Domain\Equipment\Dto\EquipmentInputData;

/**
 * Command creating a new equipment
 *
 * @author Mariusz Waloszczyk
 */
final readonly class CreateEquipment
{
    /**
     * @param EquipmentInputData $inputData
     */
    public function __construct(
        public EquipmentInputData $inputData,
    ) {
    }
}
