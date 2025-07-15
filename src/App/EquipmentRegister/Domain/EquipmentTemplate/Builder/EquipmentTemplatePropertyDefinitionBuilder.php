<?php

namespace App\EquipmentRegister\Domain\EquipmentTemplate\Builder;

use App\EquipmentRegister\Domain\EquipmentTemplate\Entity\EquipmentTemplatePropertyDefinition;
use App\EquipmentRegister\Domain\EquipmentTemplate\Enum\EquipmentTemplatePropertyDefinitionType;
use App\EquipmentRegister\Domain\EquipmentTemplate\ValueObject\EquipmentTemplatePropertyDefinitionId;
use App\EquipmentRegister\Domain\EquipmentTemplate\ValueObject\EquipmentTemplatePropertyDefinitionName;

/**
 * Builder for {@see EquipmentTemplatePropertyDefinition}
 *
 * @author Mariusz Waloszczyk
 */
final class EquipmentTemplatePropertyDefinitionBuilder
{
    private EquipmentTemplatePropertyDefinitionId $id;
    private EquipmentTemplatePropertyDefinitionName $name;
    private EquipmentTemplatePropertyDefinitionType $type;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->id = EquipmentTemplatePropertyDefinitionId::generate();
        $this->name = EquipmentTemplatePropertyDefinitionName::fromString('Definition' . uniqid());
        $this->type = EquipmentTemplatePropertyDefinitionType::TEXT;
    }

    /**
     * @param EquipmentTemplatePropertyDefinitionId $id
     * @return $this
     * @author Mariusz Waloszczyk
     */
    public function withId(EquipmentTemplatePropertyDefinitionId $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param EquipmentTemplatePropertyDefinitionName $name
     * @return $this
     * @author Mariusz Waloszczyk
     */
    public function withName(EquipmentTemplatePropertyDefinitionName $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param EquipmentTemplatePropertyDefinitionType $type
     * @return $this
     * @author Mariusz Waloszczyk
     */
    public function withType(EquipmentTemplatePropertyDefinitionType $type): self
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return EquipmentTemplatePropertyDefinition
     * @author Mariusz Waloszczyk
     */
    public function build(): EquipmentTemplatePropertyDefinition
    {
        return new EquipmentTemplatePropertyDefinition(
            $this->id,
            $this->type,
            $this->name,
        );
    }
}
