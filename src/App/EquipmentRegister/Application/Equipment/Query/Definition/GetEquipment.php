<?php

namespace App\EquipmentRegister\Application\Equipment\Query\Definition;


use App\EquipmentRegister\Domain\Equipment\ValueObject\EquipmentId;

/**
 * Query to get a single equipment
 *
 * @author Mariusz Waloszczyk
 */
final readonly class GetEquipment
{
    /**
     * @param EquipmentId $id
     */
    public function __construct(public EquipmentId $id)
    {
    }
}
