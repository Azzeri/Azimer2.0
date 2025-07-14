<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Application\EquipmentManufacturer\Service;

use App\EquipmentRegister\Application\EquipmentManufacturer\Query\Dto\EquipmentManufacturerQueryModel;
use App\EquipmentRegister\Domain\EquipmentManufacturer\Dto\EquipmentManufacturerInputData;
use App\EquipmentRegister\Domain\EquipmentManufacturer\ValueObject\EquipmentManufacturerId;
use App\Shared\QueryUtilities\Domain\QueryItem;
use App\Shared\QueryUtilities\Domain\QueryItemCollection;

/**
 * API service exposing equipment manufacturer operations to other bounded contexts and UI layer
 *
 * @author Mariusz Waloszczyk
 */
interface EquipmentManufacturerApiService
{
    /**
     * Return a single manufacturer or null
     *
     * @param EquipmentManufacturerId $id
     * @return QueryItem<EquipmentManufacturerQueryModel>|null
     * @author Mariusz Waloszczyk
     */
    public function findById(EquipmentManufacturerId $id): ?QueryItem;

    /**
     * Return a list of manufacturers
     *
     * @return QueryItemCollection<EquipmentManufacturerQueryModel>
     * @author Mariusz Waloszczyk
     */
    public function search(): QueryItemCollection;

    /**
     * Create a new manufacturer
     *
     * @param EquipmentManufacturerInputData $inputData
     * @return void
     * @author Mariusz Waloszczyk
     */
    public function createManufacturer(EquipmentManufacturerInputData $inputData): void;
}
