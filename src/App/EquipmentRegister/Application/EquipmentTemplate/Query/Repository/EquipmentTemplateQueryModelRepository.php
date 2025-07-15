<?php

namespace App\EquipmentRegister\Application\EquipmentTemplate\Query\Repository;

use App\EquipmentRegister\Application\EquipmentTemplate\Query\Dto\EquipmentTemplateQueryModel;
use App\EquipmentRegister\Domain\EquipmentTemplate\ValueObject\EquipmentTemplateId;

/**
 * Interface retrieving {@see EquipmentTemplateQueryModel}
 *
 * @author Mariusz Waloszczyk
 */
interface EquipmentTemplateQueryModelRepository
{
    /**
     * Retrieve a single template or null if not found
     *
     * @param EquipmentTemplateId $id
     * @return EquipmentTemplateQueryModel|null
     * @author Mariusz Waloszczyk
     */
    public function findById(EquipmentTemplateId $id): ?EquipmentTemplateQueryModel;

    /**
     * Return list of templates
     *
     * @return array<int, EquipmentTemplateQueryModel>
     * @author Mariusz Waloszczyk
     */
    public function search(): array;
}
