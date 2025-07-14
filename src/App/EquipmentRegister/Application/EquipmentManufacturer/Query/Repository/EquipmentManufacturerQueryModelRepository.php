<?php

namespace App\EquipmentRegister\Application\EquipmentManufacturer\Query\Repository;

use App\EquipmentRegister\Application\EquipmentCategory\Query\Dto\EquipmentCategoryQueryModel;
use App\EquipmentRegister\Application\EquipmentManufacturer\Query\Dto\EquipmentManufacturerQueryModel;
use App\EquipmentRegister\Domain\EquipmentManufacturer\ValueObject\EquipmentManufacturerId;

/**
 * Interface retrieving {@see EquipmentManufacturerQueryModel}
 *
 * @author Mariusz Waloszczyk
 */
interface EquipmentManufacturerQueryModelRepository
{
    /**
     * Retrieve a single manufacturer or null if not found
     *
     * @param EquipmentManufacturerId $id
     * @return EquipmentCategoryQueryModel|null
     * @author Mariusz Waloszczyk
     */
    public function findById(EquipmentManufacturerId $id): ?EquipmentManufacturerQueryModel;

    /**
     * Return list of manufacturers
     *
     * @return array<int, EquipmentManufacturerQueryModel>
     * @author Mariusz Waloszczyk
     */
    public function search(): array;
}
