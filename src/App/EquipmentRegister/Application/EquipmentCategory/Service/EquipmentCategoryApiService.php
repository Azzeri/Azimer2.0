<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Application\EquipmentCategory\Service;

use App\EquipmentRegister\Application\EquipmentCategory\Query\Dto\EquipmentCategoryQueryModel;
use App\EquipmentRegister\Domain\EquipmentCategory\Dto\EquipmentCategoryInputData;
use App\EquipmentRegister\Domain\EquipmentCategory\ValueObject\EquipmentCategoryId;
use App\Shared\QueryUtilities\Domain\QueryItem;
use App\Shared\QueryUtilities\Domain\QueryItemCollection;

/**
 * API service exposing equipment category operations to other bounded contexts and UI layer
 *
 * @author Mariusz Waloszczyk
 */
interface EquipmentCategoryApiService
{
    /**
     * Return a single category or null
     *
     * @param EquipmentCategoryId $categoryId
     * @return QueryItem<EquipmentCategoryQueryModel>|null
     * @author Mariusz Waloszczyk
     */
    public function findById(EquipmentCategoryId $categoryId): ?QueryItem;

    /**
     * Return a list of categories
     *
     * @return QueryItemCollection<EquipmentCategoryQueryModel>
     * @author Mariusz Waloszczyk
     */
    public function search(): QueryItemCollection;

    /**
     * Create a new category
     *
     * @param EquipmentCategoryInputData $inputData
     * @return void
     * @author Mariusz Waloszczyk
     */
    public function createCategory(EquipmentCategoryInputData $inputData): void;
}
