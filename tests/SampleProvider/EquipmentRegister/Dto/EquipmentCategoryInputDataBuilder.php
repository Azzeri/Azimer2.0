<?php

namespace Tests\SampleProvider\EquipmentRegister\Dto;

use App\EquipmentRegister\Domain\EquipmentCategory\Dto\EquipmentCategoryInputData;

/**
 * This can be used to create instances of {@see EquipmentCategoryInputData} for tests
 *
 * @author Mariusz Waloszczyk
 */
final class EquipmentCategoryInputDataBuilder
{
    private string $name;
    private ?string $parentCategoryUuid;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->name = "Helmet";
        $this->parentCategoryUuid = null;
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
     * @param string $uuid
     * @return $this
     * @author Mariusz Waloszczyk
     */
    public function withParentCategory(string $uuid): self
    {
        $this->parentCategoryUuid = $uuid;
        return $this;
    }

    /**
     * @return EquipmentCategoryInputData
     * @author Mariusz Waloszczyk
     */
    public function build(): EquipmentCategoryInputData
    {
        return new EquipmentCategoryInputData(
            $this->name,
            $this->parentCategoryUuid
        );
    }
}
