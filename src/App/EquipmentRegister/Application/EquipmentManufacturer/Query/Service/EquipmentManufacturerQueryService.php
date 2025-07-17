<?php

namespace App\EquipmentRegister\Application\EquipmentManufacturer\Query\Service;

use App\EquipmentRegister\Application\EquipmentManufacturer\Query\Definition\GetEquipmentManufacturer;
use App\EquipmentRegister\Application\EquipmentManufacturer\Query\Definition\SearchEquipmentManufacturers;
use App\EquipmentRegister\Application\EquipmentManufacturer\Query\Dto\EquipmentManufacturerQueryModel;
use App\Shared\QueryUtilities\Domain\QueryItem;
use App\Shared\QueryUtilities\Domain\QueryItemCollection;

/**
 * Query service for equipment mmanufacturers
 *
 * @author Mariusz Waloszczyk
 */
interface EquipmentManufacturerQueryService
{
    /**
     * @param GetEquipmentManufacturer $query
     * @return QueryItem<EquipmentManufacturerQueryModel>|null
     * @author Mariusz Waloszczyk
     */
    public function findOne(GetEquipmentManufacturer $query): ?QueryItem;

    /**
     * @param SearchEquipmentManufacturers $query
     * @return QueryItemCollection<EquipmentManufacturerQueryModel>
     * @author Mariusz Waloszczyk
     */
    public function search(SearchEquipmentManufacturers $query): QueryItemCollection;
}
