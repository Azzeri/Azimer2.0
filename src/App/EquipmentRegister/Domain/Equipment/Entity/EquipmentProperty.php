<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Domain\Equipment\Entity;

use App\EquipmentRegister\Domain\Equipment\Equipment;
use App\EquipmentRegister\Domain\Equipment\ValueObject\EquipmentPropertyValue;
use App\EquipmentRegister\Domain\EquipmentTemplate\Entity\EquipmentTemplateProperty;
use App\Shared\DomainUtilities\Domain\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Entity representing a specific property of an equipment piece, based on a property template definition
 *
 * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
 */
#[ORM\Entity]
class EquipmentProperty extends Entity
{
    /**
     * @param EquipmentPropertyValue $value
     * @param Equipment $equipment
     * @param EquipmentTemplateProperty $templateProperty
     * @param int|null $id
     */
    public function __construct(
        #[ORM\Embedded(class: EquipmentPropertyValue::class)]
        private EquipmentPropertyValue $value,
        #[ORM\ManyToOne(targetEntity: Equipment::class, inversedBy: 'properties')]
        #[ORM\JoinColumn(nullable: false)]
        private Equipment $equipment,
        #[ORM\ManyToOne(targetEntity: EquipmentTemplateProperty::class)]
        private EquipmentTemplateProperty $templateProperty,
        #[ORM\Id]
        #[ORM\GeneratedValue]
        #[ORM\Column]
        private ?int $id = null,
    ) {
    }

    /**
     * @return EquipmentTemplateProperty
     * @author Mariusz Waloszczyk
     */
    public function getEquipmentTemplateProperty(): EquipmentTemplateProperty
    {
        return $this->templateProperty;
    }

    /**
     * @return EquipmentPropertyValue
     * @author Mariusz Waloszczyk
     */
    public function getValue(): EquipmentPropertyValue
    {
        return $this->value;
    }
}
