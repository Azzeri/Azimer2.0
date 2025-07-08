<?php

namespace App\EquipmentRegister\Application\EquipmentCategory\Query\Definition;

use App\EquipmentRegister\Domain\EquipmentCategory\ValueObject\EquipmentCategoryId;

/**
 * Query to get a single equipment category
 *
 * @author Mariusz Waloszczyk
 */
final readonly class GetEquipmentCategory
{
    /**
     * @param EquipmentCategoryId $id
     */
    public function __construct(public EquipmentCategoryId $id)
    {
    }
}
