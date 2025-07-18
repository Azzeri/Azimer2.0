<?php

namespace App\EquipmentRegister\Domain\EquipmentTemplate\Builder;

use App\EquipmentRegister\Domain\EquipmentCategory\Builder\EquipmentCategoryBuilder;
use App\EquipmentRegister\Domain\EquipmentCategory\EquipmentCategory;
use App\EquipmentRegister\Domain\EquipmentManufacturer\Builder\EquipmentManufacturerBuilder;
use App\EquipmentRegister\Domain\EquipmentManufacturer\EquipmentManufacturer;
use App\EquipmentRegister\Domain\EquipmentTemplate\EquipmentTemplate;
use App\EquipmentRegister\Domain\EquipmentTemplate\ValueObject\EquipmentTemplateId;
use App\EquipmentRegister\Domain\EquipmentTemplate\ValueObject\EquipmentTemplateName;

/**
 * Builder for {@see EquipmentTemplate}
 *
 * @author Mariusz Waloszczyk
 */
final class EquipmentTemplateBuilder
{
    private EquipmentTemplateId $id;
    private EquipmentTemplateName $name;
    private EquipmentCategory $category;
    private EquipmentManufacturer $manufacturer;

    /**
     * Constructor
     */
    public function __construct()
    {
        $category = (new EquipmentCategoryBuilder())->build();
        $manufacturer = (new EquipmentManufacturerBuilder())->build();

        $this->id = EquipmentTemplateId::generate();
        $this->name = EquipmentTemplateName::fromString('Template' . uniqid());
        $this->category = $category;
        $this->manufacturer = $manufacturer;
    }

    /**
     * @param EquipmentTemplateId $id
     * @return $this
     * @author Mariusz Waloszczyk
     */
    public function withId(EquipmentTemplateId $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param EquipmentTemplateName $name
     * @return $this
     * @author Mariusz Waloszczyk
     */
    public function withName(EquipmentTemplateName $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param EquipmentCategory $category
     * @return $this
     * @author Mariusz Waloszczyk
     */
    public function withCategory(EquipmentCategory $category): self
    {
        $this->category = $category;
        return $this;
    }

    /**
     * @param EquipmentManufacturer $manufacturer
     * @return $this
     * @author Mariusz Waloszczyk
     */
    public function withManufacturer(EquipmentManufacturer $manufacturer): self
    {
        $this->manufacturer = $manufacturer;
        return $this;
    }

    /**
     * @return EquipmentTemplate
     * @author Mariusz Waloszczyk
     */
    public function build(): EquipmentTemplate
    {
        return new EquipmentTemplate(
            $this->id,
            $this->name,
            $this->category,
            $this->manufacturer,
        );
    }
}
