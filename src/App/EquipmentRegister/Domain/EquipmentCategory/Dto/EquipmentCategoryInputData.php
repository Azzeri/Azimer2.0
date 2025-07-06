<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Domain\EquipmentCategory\Dto;

use App\Shared\DomainUtilities\Domain\DataTransferObject;

/**
 * Input data required to create a category
 *
 * @author Mariusz Waloszczyk
 */
final readonly class EquipmentCategoryInputData extends DataTransferObject
{
    /**
     * @param string $name
     * @param string|null $parentCategoryId
     */
    public function __construct(
        public string $name,
        public ?string $parentCategoryId = null
    ) {
    }
}
