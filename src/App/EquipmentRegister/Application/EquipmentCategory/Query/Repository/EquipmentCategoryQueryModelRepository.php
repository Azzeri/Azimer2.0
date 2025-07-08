<?php

namespace App\EquipmentRegister\Application\EquipmentCategory\Query\Repository;

use App\EquipmentRegister\Application\EquipmentCategory\Query\Dto\EquipmentCategoryQueryModel;
use App\EquipmentRegister\Domain\EquipmentCategory\ValueObject\EquipmentCategoryId;

/**
 * Interface retrieving {@see EquipmentCategoryQueryModel}
 *
 * @author Mariusz Waloszczyk
 */
interface EquipmentCategoryQueryModelRepository
{
    /**
     * Retrieve a single category or null if not found
     *
     * @param EquipmentCategoryId $id
     * @return EquipmentCategoryQueryModel|null
     * @author Mariusz Waloszczyk
     */
    public function findById(EquipmentCategoryId $id): ?EquipmentCategoryQueryModel;

    /**
     * Return list of categories
     *
     * @return array<int, EquipmentCategoryQueryModel>
     * @author Mariusz Waloszczyk
     */
    public function search(): array;
}
