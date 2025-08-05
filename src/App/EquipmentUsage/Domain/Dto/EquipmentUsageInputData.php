<?php

declare(strict_types=1);

namespace App\EquipmentUsage\Domain\Dto;

use App\Shared\DomainUtilities\Domain\DataTransferObject;

/**
 * Input data required to record equipment usage
 *
 * @author Mariusz Waloszczyk
 */
final readonly class EquipmentUsageInputData extends DataTransferObject
{
    /**
     * @param string $usedEquipmentId
     * @param string $usingPersonId
     * @param string $usedFrom
     * @param string $usedTo
     * @param string|null $description
     */
    public function __construct(
        public string $usedEquipmentId,
        public string $usingPersonId,
        public string $usedFrom,
        public string $usedTo,
        public ?string $description = null
    ) {
    }
}
