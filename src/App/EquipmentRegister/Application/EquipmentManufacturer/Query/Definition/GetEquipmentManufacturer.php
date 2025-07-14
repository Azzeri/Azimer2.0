<?php

namespace App\EquipmentRegister\Application\EquipmentManufacturer\Query\Definition;


use App\EquipmentRegister\Domain\EquipmentManufacturer\ValueObject\EquipmentManufacturerId;

/**
 * Query to get a single equipment manufacturer
 *
 * @author Mariusz Waloszczyk
 */
final readonly class GetEquipmentManufacturer
{
    /**
     * @param EquipmentManufacturerId $id
     */
    public function __construct(public EquipmentManufacturerId $id)
    {
    }
}
