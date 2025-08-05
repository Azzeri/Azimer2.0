<?php

declare(strict_types=1);

namespace App\EquipmentUsage\Application\Command\RecordEquipmentUsage;

use App\EquipmentUsage\Domain\Dto\EquipmentUsageInputData;

/**
 * Command recording a new equipment usage
 *
 * @author Mariusz Waloszczyk
 */
final readonly class RecordEquipmentUsage
{
    /**
     * @param EquipmentUsageInputData $inputData
     */
    public function __construct(
        public EquipmentUsageInputData $inputData,
    ) {
    }
}
