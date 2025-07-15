<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Application\EquipmentTemplate\Service;

use App\EquipmentRegister\Domain\EquipmentTemplate\Dto\EquipmentTemplateInputData;

/**
 * API service exposing equipment template operations to other bounded contexts and UI layer
 *
 * @author Mariusz Waloszczyk
 */
interface EquipmentTemplateApiService
{
//    /**
//     * Return a single template or null
//     *
//     * @param EquipmentTemplateId $id
//     * @return QueryItem<EquipmentManufacturerQueryModel>|null
//     * @author Mariusz Waloszczyk
//     */
//    public function findById(EquipmentTemplateId $id): ?QueryItem;
//
//    /**
//     * Return a list of templates
//     *
//     * @return QueryItemCollection<EquipmentTemplateQueryModel>
//     * @author Mariusz Waloszczyk
//     */
//    public function search(): QueryItemCollection;

    /**
     * Create a new template
     *
     * @param EquipmentTemplateInputData $inputData
     * @return void
     * @author Mariusz Waloszczyk
     */
    public function createTemplate(EquipmentTemplateInputData $inputData): void;
}
