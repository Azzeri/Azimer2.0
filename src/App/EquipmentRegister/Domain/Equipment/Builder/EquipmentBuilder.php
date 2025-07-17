<?php

namespace App\EquipmentRegister\Domain\Equipment\Builder;

use App\EquipmentRegister\Domain\Equipment\Enum\EquipmentStatus;
use App\EquipmentRegister\Domain\Equipment\Equipment;
use App\EquipmentRegister\Domain\Equipment\ValueObject\EquipmentId;
use App\EquipmentRegister\Domain\Equipment\ValueObject\EquipmentOwnerId;
use App\EquipmentRegister\Domain\EquipmentTemplate\Builder\EquipmentTemplateBuilder;
use App\EquipmentRegister\Domain\EquipmentTemplate\Builder\EquipmentTemplatePropertyDefinitionBuilder;
use App\EquipmentRegister\Domain\EquipmentTemplate\EquipmentTemplate;

/**
 * Builder for {@see Equipment}
 *
 * @author Mariusz Waloszczyk
 */
final class EquipmentBuilder
{
    private EquipmentId $id;
    private EquipmentStatus $status;
    private EquipmentTemplate $template;
    private EquipmentOwnerId $owner;

    /**
     * Constructor
     */
    public function __construct()
    {
        $template = (new EquipmentTemplateBuilder())->build();
        $property = (new EquipmentTemplatePropertyDefinitionBuilder())->build();
        $template->assignProperty($property, true);

        $this->template = $template;
        $this->id = EquipmentId::generate();
        $this->status = EquipmentStatus::ACTIVE;
        $this->owner = EquipmentOwnerId::generate();
    }

    /**
     * @param EquipmentId $id
     * @return $this
     * @author Mariusz Waloszczyk
     */
    public function withId(EquipmentId $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param EquipmentStatus $status
     * @return $this
     * @author Mariusz Waloszczyk
     */
    public function withStatus(EquipmentStatus $status): self
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @param EquipmentTemplate $template
     * @return $this
     * @author Mariusz Waloszczyk
     */
    public function withTemplate(EquipmentTemplate $template): self
    {
        $this->template = $template;
        return $this;
    }

    /**
     * @param EquipmentOwnerId $ownerId
     * @return $this
     * @author Mariusz Waloszczyk
     */
    public function withOwner(EquipmentOwnerId $ownerId): self
    {
        $this->owner = $ownerId;
        return $this;
    }

    /**
     * @return Equipment
     * @author Mariusz Waloszczyk
     */
    public function build(): Equipment
    {
        return new Equipment(
            $this->id,
            $this->status,
            $this->template,
            $this->owner
        );
    }
}
