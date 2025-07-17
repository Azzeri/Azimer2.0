<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Domain\EquipmentTemplate\Entity;

use App\EquipmentRegister\Domain\EquipmentTemplate\Enum\EquipmentTemplatePropertyDefinitionType;
use App\EquipmentRegister\Domain\EquipmentTemplate\EquipmentTemplate;
use App\Shared\DomainUtilities\Domain\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * This entity represents assignment between equipment template and property definition
 *
 * @author Mariusz Waloszczyk
 */
#[ORM\Entity]
final class EquipmentTemplateProperty extends Entity
{
    /**
     * @param int|null $id
     * @param EquipmentTemplate $template
     * @param EquipmentTemplatePropertyDefinition $definition
     * @param bool $isRequired
     */
    public function __construct(
        #[ORM\ManyToOne(targetEntity: EquipmentTemplate::class, inversedBy: "properties")]
        private EquipmentTemplate $template,
        #[ORM\ManyToOne(targetEntity: EquipmentTemplatePropertyDefinition::class)]
        private EquipmentTemplatePropertyDefinition $definition,
        #[ORM\Column]
        private bool $isRequired,
        #[ORM\Id]
        #[ORM\GeneratedValue]
        #[ORM\Column]
        private ?int $id = null,
    ) {
    }

    /**
     * @return int|null
     * @author Mariusz Waloszczyk
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return EquipmentTemplatePropertyDefinition
     * @author Mariusz Waloszczyk
     */
    public function getDefinition(): EquipmentTemplatePropertyDefinition
    {
        return $this->definition;
    }

    /**
     * @return EquipmentTemplatePropertyDefinitionType
     * @author Mariusz Waloszczyk
     */
    public function getPropertyType(): EquipmentTemplatePropertyDefinitionType
    {
        return $this->getDefinition()
            ->getPropertyType();
    }

    /**
     * @return bool
     * @author Mariusz Waloszczyk
     */
    public function isRequired(): bool
    {
        return $this->isRequired;
    }
}
