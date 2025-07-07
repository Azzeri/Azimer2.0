<?php

namespace Tests\SampleProvider\EquipmentRegister\Dto;

use App\EquipmentRegister\Domain\EquipmentManufacturer\Dto\EquipmentManufacturerInputData;

/**
 * This can be used to create instances of {@see EquipmentManufacturerInputData} for tests
 *
 * @author Mariusz Waloszczyk
 */
final class EquipmentManufacturerInputDataBuilder
{
    private string $name;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->name = "Google";
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
     * @return EquipmentManufacturerInputData
     * @author Mariusz Waloszczyk
     */
    public function build(): EquipmentManufacturerInputData
    {
        return new EquipmentManufacturerInputData(
            $this->name,
        );
    }
}
