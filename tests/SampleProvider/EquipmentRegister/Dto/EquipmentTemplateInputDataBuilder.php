<?php

namespace Tests\SampleProvider\EquipmentRegister\Dto;

use App\EquipmentRegister\Domain\EquipmentTemplate\Dto\EquipmentTemplateInputData;
use App\EquipmentRegister\Domain\EquipmentTemplate\Dto\EquipmentTemplateInputDataProperty;
use Symfony\Component\Uid\Uuid;

/**
 * This can be used to create instances of {@see EquipmentTemplateInputData} for tests
 *
 * @author Mariusz Waloszczyk
 */
final class EquipmentTemplateInputDataBuilder
{
    private string $name;
    private string $category;
    private string $manufacturer;
    /** @var array<int, EquipmentTemplateInputDataProperty> $properties */
    private array $properties;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->name = "Sample template";
        $this->category = Uuid::v4()->toString();
        $this->manufacturer = Uuid::v4()->toString();
        $this->properties = [];
    }

    /**
     * @param string $name
     * @return $this
     * @author Mariusz Waloszczyk
     */
    public function withName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param string $category
     * @return $this
     * @author Mariusz Waloszczyk
     */
    public function withCategory(string $category): self
    {
        $this->category = $category;
        return $this;
    }

    /**
     * @param string $manufacturer
     * @return $this
     * @author Mariusz Waloszczyk
     */
    public function withManufacturer(string $manufacturer): self
    {
        $this->manufacturer = $manufacturer;
        return $this;
    }

    /**
     * @param array<int, EquipmentTemplateInputDataProperty> $properties
     * @return $this
     * @author Mariusz Waloszczyk
     */
    public function withProperties(array $properties): self
    {
        $this->properties = $properties;
        return $this;
    }

    /**
     * @return EquipmentTemplateInputData
     * @author Mariusz Waloszczyk
     */
    public function build(): EquipmentTemplateInputData
    {
        return new EquipmentTemplateInputData(
            $this->name,
            $this->category,
            $this->manufacturer,
            $this->properties
        );
    }
}
