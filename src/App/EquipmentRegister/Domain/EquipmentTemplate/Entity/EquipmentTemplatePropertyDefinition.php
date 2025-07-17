<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Domain\EquipmentTemplate\Entity;

use App\EquipmentRegister\Domain\EquipmentTemplate\Enum\EquipmentTemplatePropertyDefinitionType;
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
     * @param EquipmentTemplatePropertyDefinitionType $propertyType
     * @param EquipmentTemplatePropertyDefinitionName $name
     */
    public function __construct(
        #[ORM\Id]
        #[ORM\Column(type: EquipmentTemplatePropertyDefinitionIdType::NAME, unique: true)]
        private EquipmentTemplatePropertyDefinitionId $id,
        #[ORM\Column(enumType: EquipmentTemplatePropertyDefinitionType::class)]
        private EquipmentTemplatePropertyDefinitionType $propertyType,
        #[ORM\Embedded(EquipmentTemplatePropertyDefinitionName::class)]
        private EquipmentTemplatePropertyDefinitionName $name,
    ) {
    }

    /**
     * @return EquipmentTemplatePropertyDefinitionId
     * @author Mariusz Waloszczyk
     */
    public function getId(): EquipmentTemplatePropertyDefinitionId
    {
        return $this->id;
    }

    /**
     * @return EquipmentTemplatePropertyDefinitionType
     * @author Mariusz Waloszczyk
     */
    public function getPropertyType(): EquipmentTemplatePropertyDefinitionType
    {
        return $this->propertyType;
    }
}
