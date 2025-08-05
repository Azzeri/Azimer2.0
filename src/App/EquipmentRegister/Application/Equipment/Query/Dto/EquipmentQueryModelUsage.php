<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Application\Equipment\Query\Dto;

/**
 * Query model representing details of an equipment's single recorded usage
 *
 * @author Mariusz Waloszczyk
 */
final readonly class EquipmentQueryModelUsage
{
    /**
     * @param string $usageId
     * @param string $usingPersonId
     * @param string $usingPersonName
     * @param string $usedFrom
     * @param string $usedTo
     * @param string|null $description
     */
    public function __construct(
        public string $usageId,
        public string $usingPersonId,
        public string $usingPersonName,
        public string $usedFrom,
        public string $usedTo,
        public ?string $description = null,
    ) {
    }
}
