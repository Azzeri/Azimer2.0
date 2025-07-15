<?php

namespace App\EquipmentRegister\Application\EquipmentTemplate\Query\Definition;


use App\EquipmentRegister\Domain\EquipmentTemplate\ValueObject\EquipmentTemplateId;

/**
 * Query to get a single equipment template
 *
 * @author Mariusz Waloszczyk
 */
final readonly class GetEquipmentTemplate
{
    /**
     * @param EquipmentTemplateId $id
     */
    public function __construct(public EquipmentTemplateId $id)
    {
    }
}
