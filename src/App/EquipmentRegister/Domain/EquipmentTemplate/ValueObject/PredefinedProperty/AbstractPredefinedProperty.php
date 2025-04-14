<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Domain\EquipmentTemplate\ValueObject\PredefinedProperty;

use App\EquipmentRegister\Domain\EquipmentTemplate\Enum\EquipmentTemplatePropertyType;
use App\EquipmentRegister\Domain\EquipmentTemplate\ValueObject\EquipmentTemplateProperty;

/**
 * TODO - to wszystkop to chyba do equipment juz
 *
 * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
 */
abstract class AbstractPredefinedProperty extends EquipmentTemplateProperty
{
    protected function __construct(
        private int $id,//VO
        private EquipmentTemplatePropertyType $propertyType,
        private string $name,//VO
    )
    {
        parent::__construct($id, $propertyType, $name);
    }
}
