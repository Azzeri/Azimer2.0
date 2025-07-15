<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Application\EquipmentTemplate\Query\Dto;

use App\Shared\DomainUtilities\Domain\DataTransferObject;

/**
 * Query model representing an equipment template
 *
 * @author Mariusz Waloszczyk
 */
final readonly class EquipmentTemplateQueryModel extends DataTransferObject
{
    /**
     * @param string $id
     * @param string $name
     * @param EquipmentTemplateQueryModelCategory $category
     * @param EquipmentTemplateQueryModelManufacturer $manufacturer
     * @param array<int, EquipmentTemplateQueryModelProperty> $properties
     */
    public function __construct(
        public string $id,
        public string $name,
        public EquipmentTemplateQueryModelCategory $category,
        public EquipmentTemplateQueryModelManufacturer $manufacturer,
        public array $properties,
    ) {
    }
}
