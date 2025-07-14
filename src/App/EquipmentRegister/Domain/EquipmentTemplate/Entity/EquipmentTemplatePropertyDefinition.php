<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Domain\EquipmentTemplate\Entity;

use App\EquipmentRegister\Domain\EquipmentTemplate\Enum\EquipmentTemplatePropertyType;
use App\EquipmentRegister\Domain\EquipmentTemplate\ValueObject\EquipmentTemplatePropertyDefinitionId;
use App\EquipmentRegister\Domain\EquipmentTemplate\ValueObject\EquipmentTemplatePropertyDefinitionName;
use App\EquipmentRegister\Infrastructure\EquipmentTemplate\Repository\Persistence\Doctrine\Type\Identifier\EquipmentTemplatePropertyDefinitionIdType;
use App\Shared\DomainUtilities\Domain\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * This is definition of a property that can be assigned to an equipment template
 *
 * @author Mariusz Waloszczyk
 */
#[ORM\Entity]
final class EquipmentTemplatePropertyDefinition extends Entity
{
    /**
     * @param EquipmentTemplatePropertyDefinitionId $id
     * @param EquipmentTemplatePropertyType $propertyType
     * @param EquipmentTemplatePropertyDefinitionName $name
     */
    public function __construct(
        #[ORM\Id]
        #[ORM\GeneratedValue]
        #[ORM\Column(type: EquipmentTemplatePropertyDefinitionIdType::NAME, unique: true)]
        private EquipmentTemplatePropertyDefinitionId $id,
        #[ORM\Column(enumType: EquipmentTemplatePropertyType::class)]
        private EquipmentTemplatePropertyType $propertyType,
        #[ORM\Embedded(EquipmentTemplatePropertyDefinitionName::class)]
        private EquipmentTemplatePropertyDefinitionName $name,
    ) {
    }
}
