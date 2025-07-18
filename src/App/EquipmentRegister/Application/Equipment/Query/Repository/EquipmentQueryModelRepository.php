<?php

namespace App\EquipmentRegister\Application\Equipment\Query\Repository;

use App\EquipmentRegister\Application\Equipment\Query\Dto\EquipmentQueryModel;
use App\EquipmentRegister\Domain\Equipment\ValueObject\EquipmentId;

/**
 * Interface retrieving {@see EquipmentQueryModel}
 *
 * @author Mariusz Waloszczyk
 */
interface EquipmentQueryModelRepository
{
    /**
     * Retrieve a single equipment or null if not found
     *
     * @param EquipmentId $id
     * @return EquipmentQueryModel|null
     * @author Mariusz Waloszczyk
     */
    public function findById(EquipmentId $id): ?EquipmentQueryModel;

    /**
     * Return list of equipments
     *
     * @return array<int, EquipmentQueryModel>
     * @author Mariusz Waloszczyk
     */
    public function search(): array;
}
