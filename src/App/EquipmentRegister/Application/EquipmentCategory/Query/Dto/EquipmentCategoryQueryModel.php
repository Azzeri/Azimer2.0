<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Application\EquipmentCategory\Query\Dto;

use App\Shared\DomainUtilities\Domain\DataTransferObject;

/**
 * Query model representing an equipment category
 *
 * @author Mariusz Waloszczyk
 */
final readonly class EquipmentCategoryQueryModel extends DataTransferObject
{
    /**
     * @param string $id
     * @param string $name
     * @param array<int, EquipmentCategoryQueryModel> $subcategories
     * @param EquipmentCategoryQueryModel|null $parentCategoryId
     */
    public function __construct(
        public string $id,
        public string $name,
        public array $subcategories,
        public ?EquipmentCategoryQueryModel $parentCategoryId = null
    ) {
    }
}
