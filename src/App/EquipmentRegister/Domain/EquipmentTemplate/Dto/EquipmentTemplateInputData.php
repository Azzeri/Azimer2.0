<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Domain\EquipmentTemplate\Dto;

use App\Shared\DomainUtilities\Domain\DataTransferObject;

/**
 * Input data required to create an equipment template
 *
 * @author Mariusz Waloszczyk
 */
final readonly class EquipmentTemplateInputData extends DataTransferObject
{
    /**
     * @param string $name
     * @param string $categoryId
     * @param string $manufacturerId
     * @param array<int, EquipmentTemplateInputDataProperty> $properties
     */
    public function __construct(
        public string $name,
        public string $categoryId,
        public string $manufacturerId,
        public array $properties
    ) {
    }
}
