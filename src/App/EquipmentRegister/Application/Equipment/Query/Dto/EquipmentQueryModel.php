<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Application\Equipment\Query\Dto;

/**
 * Query model representing a single equipment
 *
 * @author Mariusz Waloszczyk
 */
final readonly class EquipmentQueryModel
{
    /**
     * @param string $id
     * @param string $status
     * @param string $name
     * @param string $owner
     * @param EquipmentQueryModelManufacturer $manufacturer
     * @param EquipmentQueryModelCategory $category
     * @param array<int, EquipmentQueryModelProperty> $properties
     */
    public function __construct(
        public string $id,
        public string $status,
        public string $name,
        public string $owner,
        public EquipmentQueryModelManufacturer $manufacturer,
        public EquipmentQueryModelCategory $category,
        public array $properties
    ) {
    }
}
