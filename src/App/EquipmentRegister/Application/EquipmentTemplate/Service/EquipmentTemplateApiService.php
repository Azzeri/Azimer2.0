<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Application\EquipmentTemplate\Service;

use App\EquipmentRegister\Application\EquipmentTemplate\Query\Dto\EquipmentTemplateQueryModel;
use App\EquipmentRegister\Domain\EquipmentTemplate\Dto\EquipmentTemplateInputData;
use App\EquipmentRegister\Domain\EquipmentTemplate\ValueObject\EquipmentTemplateId;
use App\Shared\QueryUtilities\Domain\QueryItem;
use App\Shared\QueryUtilities\Domain\QueryItemCollection;

/**
 * API service exposing equipment template operations to other bounded contexts and UI layer
 *
 * @author Mariusz Waloszczyk
 */
interface EquipmentTemplateApiService
{
    /**
     * Return a single template or null
     *
     * @param EquipmentTemplateId $id
     * @return QueryItem<EquipmentTemplateQueryModel>|null
     * @author Mariusz Waloszczyk
     */
    public function findById(EquipmentTemplateId $id): ?QueryItem;

    /**
     * Return a list of templates
     *
     * @return QueryItemCollection<EquipmentTemplateQueryModel>
     * @author Mariusz Waloszczyk
     */
    public function search(): QueryItemCollection;

    /**
     * Create a new template
     *
     * @param EquipmentTemplateInputData $inputData
     * @return void
     * @author Mariusz Waloszczyk
     */
    public function createTemplate(EquipmentTemplateInputData $inputData): void;
}
