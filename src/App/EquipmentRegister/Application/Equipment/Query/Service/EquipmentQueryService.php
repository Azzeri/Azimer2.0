<?php

namespace App\EquipmentRegister\Application\Equipment\Query\Service;

use App\EquipmentRegister\Application\Equipment\Query\Definition\GetEquipment;
use App\EquipmentRegister\Application\Equipment\Query\Definition\SearchEquipments;
use App\EquipmentRegister\Application\Equipment\Query\Dto\EquipmentQueryModel;
use App\Shared\QueryUtilities\Domain\QueryItem;
use App\Shared\QueryUtilities\Domain\QueryItemCollection;

/**
 * Query service for equipment
 *
 * @author Mariusz Waloszczyk
 */
interface EquipmentQueryService
{
    /**
     * @param GetEquipment $query
     * @return QueryItem<EquipmentQueryModel>|null
     * @author Mariusz Waloszczyk
     */
    public function findOne(GetEquipment $query): ?QueryItem;

    /**
     * @param SearchEquipments $query
     * @return QueryItemCollection<EquipmentQueryModel>
     * @author Mariusz Waloszczyk
     */
    public function search(SearchEquipments $query): QueryItemCollection;
}
