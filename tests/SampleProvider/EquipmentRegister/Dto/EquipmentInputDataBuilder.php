<?php

namespace Tests\SampleProvider\EquipmentRegister\Dto;

use App\EquipmentRegister\Domain\Equipment\Dto\EquipmentInputData;
use App\EquipmentRegister\Domain\Equipment\Dto\EquipmentInputDataProperty;
use App\EquipmentRegister\Domain\Equipment\ValueObject\EquipmentOwnerId;
use App\EquipmentRegister\Domain\EquipmentTemplate\ValueObject\EquipmentTemplateId;
use App\EquipmentRegister\Domain\EquipmentTemplate\ValueObject\EquipmentTemplatePropertyDefinitionId;

/**
 * This can be used to create instances of {@see EquipmentInputData} for tests
 *
 * @author Mariusz Waloszczyk
 */
final class EquipmentInputDataBuilder
{
    private string $templateId;
    private string $ownerId;
    private array $properties;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->templateId = EquipmentTemplateId::generate()->toString();
        $this->ownerId = EquipmentOwnerId::generate()->toString();
        $this->properties = [
            new EquipmentInputDataProperty(EquipmentTemplatePropertyDefinitionId::generate()->toString(), 'test'),
            new EquipmentInputDataProperty(EquipmentTemplatePropertyDefinitionId::generate()->toString(), 'test'),
        ];
    }

    /**
     * @param string $templateId
     * @return $this
     * @author Mariusz Waloszczyk
     */
    public function withTemplateId(string $templateId): self
    {
        $this->templateId = $templateId;
        return $this;
    }

    /**
     * @param string $ownerId
     * @return $this
     * @author Mariusz Waloszczyk
     */
    public function withOwnerId(string $ownerId): self
    {
        $this->ownerId = $ownerId;
        return $this;
    }

    /**
     * @param array<int, EquipmentInputDataProperty> $properties
     * @return $this
     * @author Mariusz Waloszczyk
     */
    public function withProperties(array $properties): self
    {
        $this->properties = $properties;
        return $this;
    }

    /**
     * @return EquipmentInputData
     * @author Mariusz Waloszczyk
     */
    public function build(): EquipmentInputData
    {
        return new EquipmentInputData(
            $this->templateId,
            $this->ownerId,
            $this->properties
        );
    }
}
