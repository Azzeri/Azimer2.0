<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Domain\Equipment\Dto;

use App\Shared\DomainUtilities\Domain\DataTransferObject;

/**
 * Input data required to create an equipment
 *
 * @author Mariusz Waloszczyk
 */
final readonly class EquipmentInputData extends DataTransferObject
{
    /**
     * @param string $templateId
     * @param string $ownerId
     * @param array<int, EquipmentInputDataProperty> $properties
     */
    public function __construct(
        public string $templateId,
        public string $ownerId,
        public array $properties,
    ) {
    }
}
